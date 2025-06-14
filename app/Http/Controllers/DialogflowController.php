<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Revente;
use App\Models\Flight;

class DialogflowController extends Controller
{
    public function handle(Request $request)
    {
            $queryText = strtolower($request->input('queryResult.queryText'));
            $intent = $request->input('queryResult.intent.displayName', '');

            // Handle reservation status queries
            if (str_contains($queryText, 'réservation')) {
                preg_match('/\d+/', $queryText, $matches);
                $num = $matches[0] ?? null;

                if ($num && $reservation = Reservation::where('numero', $num)->first()) {
                    return response()->json([
                        'fulfillmentText' => "Votre réservation $num est actuellement : " . $reservation->status,
                    ]);
                } else {
                    return response()->json([
                        'fulfillmentText' => "Je n'ai trouvé aucune réservation avec ce numéro. Vérifiez et réessayez.",
                    ]);
                }
            }

            // Handle resale queries
            // Handle resale ticket queries
            // if (str_contains($queryText, 'revente')) {
            //     preg_match('/\d+/', $queryText, $matches);
            //     $num = $matches[0] ?? null;
            //     if ($num && $revente = Revente::where('billet_numero', $num)->first()) {
            //         return response()->json([
            //             'fulfillmentText' => "Le billet numéro $num est actuellement dans l'état : " . $revente->etat,
            //         ]);
            //     } else {
            //         return response()->json([
            //             'fulfillmentText' => "Aucune revente trouvée pour ce billet. Vérifiez le numéro et réessayez.",
            //         ]);
            //       }
            //}

        // Handle flight delay queries
        if (str_contains($queryText, 'retard') || str_contains($queryText, 'délai')) {
            preg_match('/\d+/', $queryText, $matches);
            $flightNumber = $matches[0] ?? null;

            if ($flightNumber && $flight = Flight::where('flight_number', $flightNumber)->first()) {
                if ($flight->status === 'delayed') {
                    return response()->json([
                        'fulfillmentText' => "Le vol $flightNumber est actuellement retardé. Nouvelle heure de départ prévue : " . $flight->departure_time->format('H:i'),
                    ]);
                } else if ($flight->status === 'cancelled') {
                    return response()->json([
                        'fulfillmentText' => "Nous sommes désolés, le vol $flightNumber a été annulé. Veuillez contacter notre service client pour plus d'informations.",
                    ]);
                } else {
                    return response()->json([
                        'fulfillmentText' => "Le vol $flightNumber est prévu à l'heure. Départ à " . $flight->departure_time->format('H:i'),
                    ]);
                }
            } else {
                return response()->json([
                    'fulfillmentText' => "Je n'ai pas trouvé d'informations pour le vol numéro $flightNumber. Vérifiez le numéro et réessayez.",
                ]);
            }
        }

        // Handle general flight information queries
        if (str_contains($queryText, 'vol')) {
            preg_match('/\d+/', $queryText, $matches);
            $flightNumber = $matches[0] ?? null;

            if ($flightNumber && $flight = Flight::where('flight_number', $flightNumber)->first()) {
                $destination = $flight->destination;
                $departureTime = $flight->departure_time->format('d/m/Y à H:i');
                $availableSeats = $flight->available_seats;
                
                return response()->json([
                    'fulfillmentText' => "Le vol $flightNumber à destination de $destination est prévu pour le $departureTime. Il reste $availableSeats places disponibles.",
                ]);
            }
        }

        // Default response for unrecognized queries
        return response()->json([
            'fulfillmentText' => "Je n'ai pas compris votre demande. Vous pouvez me demander des informations sur votre réservation, l'état d'un vol, ou les retards éventuels en précisant le numéro concerné.",
        ]);
    }

    // New method to handle direct chat from the website
    public function chat(Request $request)
    {
        $message = $request->input('message');
        
        // Simple keyword-based responses for direct chat
        if (str_contains(strtolower($message), 'bonjour') || str_contains(strtolower($message), 'salut')) {
            return response()->json([
                'message' => 'Bonjour ! Comment puis-je vous aider aujourd\'hui ?',
            ]);
        }
        
        // For other queries, we'll simulate a call to Dialogflow by processing the message directly
        $mockRequest = new Request();
        $mockRequest->merge(['queryResult' => ['queryText' => $message]]);
        
        $dialogflowResponse = $this->handle($mockRequest);
        $responseData = json_decode($dialogflowResponse->getContent(), true);
        
        return response()->json([
            'message' => $responseData['fulfillmentText'] ?? "Je n'ai pas compris votre demande. Pouvez-vous reformuler ?",
        ]);
    }
}