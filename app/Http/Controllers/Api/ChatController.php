<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Destination;
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
        $info = [];

        // 🔹 Détection de la date
        if (preg_match('/(\d{1,2}[\/\-\.]\d{1,2}[\/\-\.]\d{2,4})/', $message, $matches)) {
            try {
                $info['date'] = \Carbon\Carbon::parse(str_replace(['.', '-'], '/', $matches[1]))->format('Y-m-d');
            } catch (\Exception $e) {
                // Ignorer si la date n’est pas lisible
            }
        } elseif (str_contains($message, 'demain')) {
            $info['date'] = now()->addDay()->format('Y-m-d');
        } elseif (str_contains($message, 'aujourd\'hui')) {
            $info['date'] = now()->format('Y-m-d');
        } elseif (str_contains($message, 'semaine prochaine')) {
            $info['date'] = now()->addWeek()->format('Y-m-d');
        }

        // 🔹 Chargement des destinations
        $destinations = Destination::all();

        foreach ($destinations as $destination) {
            $ville = mb_strtolower($destination->ville);
            $pays = mb_strtolower($destination->pays);

            // 🔸 Ville de départ
            if (preg_match('/(de|depuis|partir de|départ de)\s+' . preg_quote($ville, '/') . '/', $message)) {
                $info['departure_city_id'] = $destination->id;
            }

            // 🔸 Ville d’arrivée
            if (preg_match('/(vers|à|pour|arrivée à|destination de|vol pour|vol vers)\s+' . preg_quote($ville, '/') . '/', $message)) {
                $info['destination_id'] = $destination->id;
            }

            // Cas ambigus : ville mentionnée sans mot-clé
            if (str_contains($message, $ville)) {
                if (!isset($info['destination_id']) && !isset($info['departure_city_id'])) {
                    $info['destination_id'] = $destination->id;
                }
            }

            // 🔸 Pays de départ / destination
            if (str_contains($message, $pays)) {
                if (!isset($info['departure_country']) && preg_match('/(de|depuis|partir de|départ de)\s+' . preg_quote($pays, '/') . '/', $message)) {
                    $info['departure_country'] = $destination->pays;
                } elseif (!isset($info['destination_country']) && preg_match('/(vers|à|pour|arrivée à|destination de|vol pour)\s+' . preg_quote($pays, '/') . '/', $message)) {
                    $info['destination_country'] = $destination->pays;
                }
            }
        }

        // 🔹 Le message contient-il des mots clés utiles pour les vols ?
        $keywords = ['vol', 'vols', 'réserver', 'destination', 'disponible', 'chercher vol'];
        $wordCount = str_word_count($message);
        $hasKeyword = collect($keywords)->contains(fn($k) => str_contains($message, $k));

        return $hasKeyword && $wordCount > 2 ? $info : false;
    }

}
