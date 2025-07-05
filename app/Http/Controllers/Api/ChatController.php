<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\OpenRouterService;
use App\Services\FlightService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    protected $openRouterService;
    protected $flightService;

    public function __construct(
        OpenRouterService $openRouterService,
        FlightService $flightService
    ) {
        $this->openRouterService = $openRouterService;
        $this->flightService = $flightService;
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'user_id' => 'nullable|integer|exists:users,id',
        ]);

        $message = trim($request->message);
        $userId = $request->user_id;

        \Log::info('Message reçu : ' . $message);
        
        // Vérifier si le message concerne une recherche de vols
        $flightInfo = $this->extractFlightInfo($message);
        \Log::info('Résultat extractFlightInfo : ', ['flightInfo' => $flightInfo]);
        
        if ($flightInfo !== false) {
            try {
                $searchParams = [
                    'date' => $flightInfo['date'] ?? null,
                    'destination_id' => $flightInfo['destination_id'] ?? null,
                    'departure_city_id' => $flightInfo['departure_city_id'] ?? null,
                    'user_id' => $userId
                ];

                $flights = $this->flightService->searchFlights($searchParams);
                $flightsInfo = $this->flightService->formatFlightsForAI($flights);
                
                return response()->json([
                    'success' => true,
                    'response' => $flightsInfo,
                    'is_flight_info' => true
                ]);
            } catch (\Exception $e) {
                Log::error('Erreur lors de la recherche de vols: ' . $e->getMessage());
            }
        }

        // Si ce n'est pas une recherche de vol, passer au traitement par l'IA
        $response = $this->openRouterService->sendMessage($message);

        return response()->json([
            'success' => true,
            'response' => $response,
            'is_flight_info' => false
        ]);
    }

    /**
     * Extrait les informations de vol du message de l'utilisateur
     */
    protected function extractFlightInfo($message)
    {
        $message = mb_strtolower(trim($message));
        $result = [];
        
        // Détection des dates dans le message
        if (preg_match('/(\d{1,2}[\/\-\.]\d{1,2}[\/\-\.]\d{2,4})/', $message, $matches)) {
            try {
                $result['date'] = \Carbon\Carbon::createFromFormat('d/m/Y', $matches[1])->format('Y-m-d');
            } catch (\Exception $e) {
                try {
                    $result['date'] = \Carbon\Carbon::createFromFormat('d-m-Y', $matches[1])->format('Y-m-d');
                } catch (\Exception $e) {
                    // Format de date non reconnu
                }
            }
        } elseif (str_contains($message, 'demain')) {
            $result['date'] = now()->addDay()->format('Y-m-d');
        } elseif (str_contains($message, 'aujourd\'hui') || str_contains($message, 'aujourd\'hui')) {
            $result['date'] = now()->format('Y-m-d');
        } elseif (str_contains($message, 'semaine prochaine')) {
            $result['date'] = now()->addWeek()->format('Y-m-d');
        }
        
        // Détection des destinations (à améliorer avec une liste de villes)
        $cities = ['paris', 'lyon', 'marseille', 'toulouse', 'nice', 'bordeaux', 'lille', 'strasbourg'];
        foreach ($cities as $city) {
            if (str_contains($message, $city)) {
                $result['destination'] = $city;
                break;
            }
        }
        
        // Détection des mentions de vols
        $flightKeywords = [
            'vol', 'vols', 'disponible', 'disponibilité', 'réserver', 'réservation',
            'destination', 'partir', 'aller à', 'cherche vol', 'trouver vol',
            'prochains vols', 'disponibles', 'disponibilités', 'disponible',
            'vol pour', 'vol vers', 'vol à destination', 'vol au départ',
            'quels vols', 'quelles compagnies', 'quelles destinations',
            'liste des vols', 'afficher les vols', 'voir les vols', 'montre-moi les vols',
            'donne-moi les vols', 'je veux voir les vols', 'je veux la liste des vols'
        ];
        
        // Détection des demandes de liste simple
        $listPatterns = [
            '/liste.*vols?/i',
            '/affiche.*vols?/i',
            '/montre.*vols?/i',
            '/donne.*vols?/i',
            '/voir.*vols?/i',
            '/vols?\s+disponibles?/i',
            '/disponibles?\s+vols?/i',
            '/je\s+veux\s+voir\s+les\s+vols/i',
            '/je\s+veux\s+la\s+liste\s+des\s+vols/i',
            '/afficher.*les.*vols/i',
            '/montrer.*les.*vols/i',
            '/lister.*les.*vols/i',
            '/quels.*sont.*les.*vols/i',
            '/quelles.*sont.*les.*vols/i',
            '/donne.*moi.*les.*vols/i',
            '/je\s+cherche\s+des\s+vols/i',
            '/je\s+veux\s+des\s+vols/i',
            '/je\s+veux\s+voir\s+des\s+vols/i',
            '/je\s+veux\s+connaître\s+les\s+vols/i'
        ];
        
        foreach ($listPatterns as $pattern) {
            if (preg_match($pattern, $message)) {
                \Log::info('Pattern matché : ' . $pattern);
                return []; // Retourne un tableau vide pour une recherche sans filtre
            }
        }
        
        $questionWords = ['quel', 'quelle', 'quels', 'quelles', 'qu\'est-ce', 'qui', 'où', 'quand', 'comment', 'pourquoi'];
        $containsQuestionWord = false;
        
        foreach ($questionWords as $word) {
            if (str_starts_with(trim($message), $word)) {
                $containsQuestionWord = true;
                break;
            }
        }
        
        $hasFlightKeyword = false;
        foreach ($flightKeywords as $keyword) {
            if (str_contains($message, $keyword)) {
                $hasFlightKeyword = true;
                break;
            }
        }
        
        // Si le message contient un mot-clé de vol ou commence par un mot interrogatif
        // et fait plus de 3 mots (pour éviter les faux positifs comme "vol" seul)
        $wordCount = count(preg_split('/\s+/', trim($message)));
        return ($hasFlightKeyword || $containsQuestionWord) && $wordCount > 2 ? $result : false;
    }
}
