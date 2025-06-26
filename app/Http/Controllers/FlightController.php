<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FlightController extends Controller
{
    public function search(Request $request)
    {
        $flights = Flight::query()
            ->when($request->departure, function($query, $departure) {
                return $query->where('ville_depart_id', $departure);
            })
            ->when($request->destination, function($query, $destination) {
                return $query->where('destination_id', $destination);
            })
            ->when($request->date, function($query, $date) {
                return $query->whereDate('departure_time', $date);
            })
            ->when($request->price_max, function($query, $price) {
                return $query->where('price', '<=', $price);
            })
            ->paginate(10);

        // Get popular destinations for the search page
        $popularDestinations = Destination::where('populaire', true)
            ->take(4)
            ->get();

        // If AJAX request, return only the results section
        if ($request->ajax() || $request->has('ajax')) {
            return view('site.pages.flights._results', [
                'flights' => $flights,
            ])->render();
        }

        return view('site.pages.flights.search', [
            'flights' => $flights,
            'popularDestinations' => $popularDestinations,
            'searchParams' => $request->all()
        ]);
    }

    public function index()
    {
        $flights = Flight::paginate(10);
        return view('administration.manager.flights.index', compact('flights'));
    }

    public function create()
    {
        $destinations = Destination::all();
        return view('administration.manager.flights.create', compact('destinations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'numero_vol' => 'required|string|max:10|unique:flights,flight_number',
            'ville_depart_id' => 'required|exists:destinations,id',
            'destination_id' => 'required|exists:destinations,id',
            'heure_depart' => 'required|date',
            'heure_arrivee' => 'required|date|after:heure_depart',
            'prix' => 'required|numeric|min:0',
            'capacite' => 'required|integer|min:1',
            'statut' => 'required|in:planifié,confirmé,annulé',
        ]);

        // Mapper les noms de champs du formulaire aux noms de colonnes de la base de données
        $flightData = [
            'flight_number' => $validated['numero_vol'],
            'ville_depart_id' => $validated['ville_depart_id'],
            'destination_id' => $validated['destination_id'],
            'departure_time' => $validated['heure_depart'],
            'arrival_time' => $validated['heure_arrivee'],
            'price' => $validated['prix'],
            'total_seats' => $validated['capacite'],
            'available_seats' => $validated['capacite'],
            'status' => $validated['statut'],
        ];

        Flight::create($flightData);
        
        return redirect()->route('manager.flights.index')
            ->with('success', 'Vol créé avec succès');
    }

    public function edit(Flight $flight)
    {
        $destinations = Destination::all();
        return view('administration.gestionnaire.flights.edit', compact('flight', 'destinations'));
    }

    public function update(Request $request, Flight $flight)
    {
        $validated = $request->validate([
            'numero_vol' => 'required|string|max:10|unique:flights,flight_number,' . $flight->id,
            'ville_depart_id' => 'required|exists:destinations,id',
            'destination_id' => 'required|exists:destinations,id',
            'heure_depart' => 'required|date',
            'heure_arrivee' => 'required|date|after:heure_depart',
            'prix' => 'required|numeric|min:0',
            'capacite' => 'required|integer|min:1',
            'statut' => 'required|in:planifié,confirmé,annulé',
        ]);

        // Mapper les noms de champs du formulaire aux noms de colonnes de la base de données
        $flightData = [
            'flight_number' => $validated['numero_vol'],
            'ville_depart_id' => $validated['ville_depart_id'],
            'destination_id' => $validated['destination_id'],
            'departure_time' => $validated['heure_depart'],
            'arrival_time' => $validated['heure_arrivee'],
            'price' => $validated['prix'],
            'total_seats' => $validated['capacite'],
            'status' => $validated['statut'],
        ];

        // Ne pas modifier le nombre de sièges disponibles si la capacité n'a pas changé
        if ($flight->total_seats != $validated['capacite']) {
            $seatsReserved = $flight->total_seats - $flight->available_seats;
            $flightData['available_seats'] = $validated['capacite'] - $seatsReserved;
        }

        $flight->update($flightData);
        
        return redirect()->route('manager.flights.index')
            ->with('success', 'Vol mis à jour avec succès');
    }

    public function destroy(Flight $flight)
    {
        try {
            // Check if flight has any reservations
            if ($flight->reservations()->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete flight with existing reservations'
                ], 400);
            }

            $flight->delete();
            
            session()->flash('success', 'Flight deleted successfully');

            return response()->json([
                'success' => true,
                'message' => 'Vol supprimé avec succès',
                'redirect' => route('manager.flights.index')
            ]);

        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression du vol',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Flight $flight)
    {
        return view('site.pages.flights.show', [
            'flight' => $flight->load('availableSeats')
        ]);
    }
}
