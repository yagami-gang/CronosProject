<?php

namespace App\Services;

use App\Models\Flight;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class FlightService
{
    /**
     * Recherche des vols selon les critères fournis
     *
     * @param array $searchParams
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function searchFlights(array $searchParams = [])
    {
        try {
            Log::info('Paramètres de recherche reçus : ', $searchParams);

            $query = Flight::with(['destination', 'villeDepart']);

            // Retirer le filtre de statut pour voir tous les vols
            // ->where('status', 'confirmé');

            if (!empty($searchParams['date'])) {
                $date = Carbon::parse($searchParams['date'])->startOfDay();
                $query->whereDate('departure_time', $date);
                Log::info('Filtre date appliqué : ' . $date->format('Y-m-d'));
            }

            if (!empty($searchParams['destination_id'])) {
                $query->where('destination_id', $searchParams['destination_id']);
                Log::info('Filtre destination_id : ' . $searchParams['destination_id']);
            }

            if (!empty($searchParams['departure_city_id'])) {
                $query->where('ville_depart_id', $searchParams['departure_city_id']);
                Log::info('Filtre ville_depart_id : ' . $searchParams['departure_city_id']);
            }

            if (!empty($searchParams['user_id'])) {
                $query->whereHas('reservations', function($q) use ($searchParams) {
                    $q->where('user_id', $searchParams['user_id']);
                });
                Log::info('Filtre user_id : ' . $searchParams['user_id']);
            }

            $sql = $query->toSql();
            $bindings = $query->getBindings();
            $results = $query->orderBy('departure_time')->get();

            Log::info('Requête SQL : ' . $sql);
            Log::info('Paramètres de liaison : ', $bindings);
            Log::info('Nombre de résultats : ' . $results->count());

            if ($results->isEmpty()) {
                // Vérifier s'il y a des vols dans la base de données
                $totalFlights = Flight::count();
                Log::info('Aucun vol trouvé. Total des vols en base : ' . $totalFlights);

                if ($totalFlights > 0) {
                    // Voir un exemple de vol existant
                    $sampleFlight = Flight::first();
                    Log::info('Exemple de vol existant : ', $sampleFlight->toArray());
                }
            }
            return $results;
        } catch (\Exception $e) {
            Log::error('Erreur lors de la recherche de vols: ' . $e->getMessage());
            return collect();
        }
    }

    /**
     * Formate les informations des vols pour l'affichage par l'IA
     *
     * @param \Illuminate\Database\Eloquent\Collection $flights
     * @return string
     */
    public function formatFlightsForAI($flights)
    {
        if ($flights->isEmpty()) {
            return "Aucun vol trouvé pour les critères donnés.";
        }

        $result = "Voici les vols disponibles :\n\n";

        foreach ($flights as $flight) {
            $departureCity = $flight->villeDepart->ville ?? 'Inconnu';
            $destinationCity = $flight->destination->ville ?? 'Inconnu';

            $result .= "✈️ *Vol {$flight->flight_number}*\n";
            $result .= "\n";
            $result .= "📍 *Départ*: {$departureCity}\n";
            $result .= "🏁 *Destination*: {$destinationCity}\n\n";
            $result .= "🕒 *Départ*: {$flight->departure_time->format('d/m/Y à H\hi')}\n";
            $result .= "🕓 *Arrivée*: {$flight->arrival_time->format('d/m/Y à H\hi')}\n\n";
            $result .= "💺 *Disponibilité*: {$flight->available_seats}/{$flight->total_seats} sièges\n";
            $result .= "💰 *Prix*: " . number_format($flight->price, 2, ',', ' ') . " Fcfa\n";
            $result .= "⏱️ *Durée du séjour*: " . ($flight->duree_sejour ?? 'Non spécifiée') . "\n";
            $result .= "⭐ *Note*: " . ($flight->note ? number_format($flight->note, 1) . "/5" : 'Non noté') . "\n";
            $result .= "\n" . str_repeat("-", 30) . "\n\n";
        }

        return $result;
    }

    /**
     * Trouve un vol par son numéro de vol
     *
     * @param string $flightNumber
     * @return Flight|null
     */
    public function findFlightByNumber($flightNumber)
    {
        return Flight::where('flight_number', $flightNumber)->first();
    }

    /**
     * Vérifie la disponibilité d'un vol
     *
     * @param int $flightId
     * @param int $seatsRequested
     * @return bool
     */
    public function checkAvailability($flightId, $seatsRequested = 1)
    {
        $flight = Flight::find($flightId);

        if (!$flight) {
            return false;
        }

        return $flight->available_seats >= $seatsRequested && $flight->status === 'active';
    }
}
