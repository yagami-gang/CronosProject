<?php

namespace Database\Seeders;

use App\Models\Flight;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class FlightSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer des vols pour différentes destinations avec des dates après le 20 juillet 2025
        $flights = [];

        // Dates de départ aléatoires après le 20 juillet 2025
        $startDate = Carbon::create(2025, 7, 21);

        // Générer des vols pour chaque ville du Cameroun
        // Douala (1) - Hub principal
        $this->createFlightsForDestination(1, 10, $startDate, $flights);

        // Yaoundé (2) - Capitale
        $this->createFlightsForDestination(2, 8, $startDate, $flights);

        // Garoua (3) - Grand Nord
        $this->createFlightsForDestination(3, 5, $startDate, $flights);

        // Bamenda (4) - Nord-Ouest
        $this->createFlightsForDestination(4, 6, $startDate, $flights);

        // Maroua (5) - Extrême-Nord
        $this->createFlightsForDestination(5, 4, $startDate, $flights);

        // Bafoussam (6) - Ouest
        $this->createFlightsForDestination(6, 5, $startDate, $flights);

        // Ngaoundéré (7) - Adamaoua
        $this->createFlightsForDestination(7, 4, $startDate, $flights);

        // Bertoua (8) - Est
        $this->createFlightsForDestination(8, 3, $startDate, $flights);

        // Loum (9) - Littoral
        $this->createFlightsForDestination(9, 5, $startDate, $flights);

        // Insérer tous les vols
        Flight::insert($flights);
    }

    // Variable statique pour stocker les numéros de vol déjà utilisés
    private static $usedFlightNumbers = [];

    private function createFlightsForDestination($destinationId, $count, $startDate, &$flights)
    {
        $airlines = [
            'Camair-Co' => 'CC',
            'Honowa Fly' => 'HF',
            'Cameroon Airlines' => 'QC',
            'Sky Power Express' => 'P4',
            'Elysian Airlines' => 'E4'
        ];

        $statuses = ['planifié', 'confirmé', 'annulé'];
        $aircrafts = ['Boeing 737-700', 'Bombardier Q400', 'ATR 72-600', 'Embraer E190'];

        // Durées de vol approximatives en minutes depuis Douala vers les autres villes
        $flightDurations = [
            1 => 0,    // Douala
            2 => 30,   // Yaoundé
            3 => 120,  // Garoua
            4 => 60,   // Bamenda
            5 => 120,  // Maroua
            6 => 45,   // Bafoussam
            7 => 90,   // Ngaoundéré
            8 => 60,   // Bertoua
            9 => 30    // Loum
        ];

        for ($i = 0; $i < $count; $i++) {
            $departureDate = $startDate->copy()->addDays(rand(0, 30));
            $departureTime = Carbon::createFromTime(rand(5, 20), rand(0, 1) * 30, 0);

            // Sélection aléatoire d'une compagnie aérienne
            $airlineName = array_rand($airlines);
            $airlineCode = $airlines[$airlineName];

            // Durée de vol réaliste selon la destination
            $flightDuration = $flightDurations[$destinationId] ?? 60; // 1h par défaut

            // Génération d'un numéro de vol unique
            do {
                $flightNumber = $airlineCode . rand(100, 999);
            } while (in_array($flightNumber, self::$usedFlightNumbers));
            
            // Ajouter le numéro de vol à la liste des utilisés
            self::$usedFlightNumbers[] = $flightNumber;

            // Capacité des avions plus réaliste pour des vols intérieurs
            $totalSeats = rand(50, 120);
            $availableSeats = rand(5, $totalSeats);

            // Prix en FCFA (de 25 000 à 150 000 FCFA)
            $price = rand(25000, 150000);

            // Durée de séjour réaliste pour des voyages d'affaires ou touristiques
            $dureeSejour = rand(1, 7); // 1 à 7 jours

            // Ville de départ aléatoire (sauf la destination d'arrivée)
            $villeDepartId = $destinationId;
            $attempts = 0;
            $maxAttempts = 10; // Pour éviter les boucles infinies
            
            while ($villeDepartId === $destinationId && $attempts < $maxAttempts) {
                $villeDepartId = rand(1, 9);
                $attempts++;
            }
            
            // Si on n'a pas trouvé de ville de départ valide, on prend Douala par défaut
            if ($villeDepartId === $destinationId) {
                $villeDepartId = 1; // Douala comme ville de départ par défaut
            }

            $flights[] = [
                'flight_number' => $flightNumber,
                'ville_depart_id' => $villeDepartId,
                'destination_id' => $destinationId,
                'departure_time' => $departureDate->copy()->setTime($departureTime->hour, $departureTime->minute),
                'arrival_time' => $departureDate->copy()
                    ->setTime($departureTime->hour, $departureTime->minute)
                    ->addMinutes($flightDuration),
                'price' => $price,
                'total_seats' => $totalSeats,
                'available_seats' => $availableSeats,
                'status' => $statuses[array_rand($statuses)],
                'duree_sejour' => $dureeSejour,
                'date_depart' => $departureDate->toDateString(),
                'prix_a_partir_de' => $price - rand(5000, 20000), // Réduction de 5 000 à 20 000 FCFA
                'note' => rand(35, 50) / 10, // Note entre 3.5 et 5.0
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Ajouter un jour pour le prochain vol
            $startDate->addDay();
        }
    }
}
