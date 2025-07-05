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
    public function searchFlights($searchParams = [])
    {
        try {
            $query = Flight::with(['destination', 'villeDepart'])
                ->where('status', 'active');

            if (!empty($searchParams['date'])) {
                $date = Carbon::parse($searchParams['date'])->startOfDay();
                $query->whereDate('departure_time', $date);
            }

            if (!empty($searchParams['destination_id'])) {
                $query->where('destination_id', $searchParams['destination_id']);
            }

            if (!empty($searchParams['departure_city_id'])) {
                $query->where('ville_depart_id', $searchParams['departure_city_id']);
            }

            if (!empty($searchParams['user_id'])) {
                $query->whereHas('reservations', function($q) use ($searchParams) {
                    $q->where('user_id', $searchParams['user_id']);
                });
            }

            return $query->orderBy('departure_time')->get();
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
            $departureCity = $flight->villeDepart->nom ?? 'Inconnu';
            $destinationCity = $flight->destination->nom ?? 'Inconnu';
            
            $result .= sprintf(
                "Vol %s :\n" .
                "- Départ : %s\n" .
                "- Destination : %s\n" .
                "- Date et heure de départ : %s\n" .
                "- Date et heure d'arrivée : %s\n" .
                "- Prix : %s €\n" .
                "- Sièges disponibles : %d/%d\n" .
                "- Durée du séjour : %s\n" .
                "- Note : %s/5\n\n",
                $flight->flight_number,
                $departureCity,
                $destinationCity,
                $flight->departure_time->format('d/m/Y H:i'),
                $flight->arrival_time->format('d/m/Y H:i'),
                number_format($flight->price, 2, ',', ' '),
                $flight->available_seats,
                $flight->total_seats,
                $flight->duree_sejour ?? 'Non spécifiée',
                $flight->note ? number_format($flight->note, 1) : 'Non noté'
            );
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
