<?php

namespace App\Http\Controllers;

use App\Models\Vol;
use DateTimeZone;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Flight;
use App\Models\Destination;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'flights_count' => Flight::count(),
            'reservations_count' => Reservation::count(),
            'destinations_count' => Destination::count(),
            'recent_reservations' => Reservation::with(['user', 'flight'])->latest()->take(5)->get(),
        ];
        $totalDestinations = Destination::count();
        $totalVols = FLight::count();
        $destinationsActives = Destination::where('statut', 'actif')->count();
        $volsPlanifies = FLight::where('status', 'planifié')->count();
        return view('administration.gestionnaire.dashboard', compact(
            'totalDestinations',
            'totalVols',
            'destinationsActives',
            'volsPlanifies'
        ));
    }

    // Flights Management
    public function flightsList()
    {
        $flights = Flight::paginate(10);
        return view('administration.gestionnaire.flights.index', compact('flights'));
    }

    public function flightsCreate()
    {
        $destinations = Destination::all();
        return view('administration.gestionnaire.flights.create', compact('destinations'));
    }

    public function flightsStore(Request $request)
    {
        $validated = $request->validate([
            'numero_vol' => 'required|string|max:10|unique:flights,flight_number',
            'ville_depart' => 'required|string|max:255',
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
            'departure' => $validated['ville_depart'],
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

    public function flightsEdit(Flight $flight)
    {
        $destinations = Destination::all();
        return view('administration.gestionnaire.flights.edit', compact('flight', 'destinations'));
    }

    public function flightsUpdate(Request $request, Flight $flight)
    {
        $validated = $request->validate([
            'numero_vol' => 'required|string|max:10|unique:flights,flight_number,' . $flight->id,
            'ville_depart' => 'required|string|max:255',
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
            'departure' => $validated['ville_depart'],
            'destination_id' => $validated['destination_id'],
            'departure_time' => $validated['heure_depart'],
            'arrival_time' => $validated['heure_arrivee'],
            'price' => $validated['prix'],
            'total_seats' => $validated['capacite'],
            'status' => $validated['statut'],
        ];

        $flight->update($flightData);
        return redirect()->route('manager.flights.index')->with('success', 'Vol mis à jour avec succès');
    }
    public function flightsDestroy(Flight $flight)
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
                'message' => 'vole supprimer avec succès',
                'redirect' => route('manager.flights.index')
            ]);

        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'erreur lors de la suppression du vol',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Destinations Management
    public function destinationsList()
    {
        $destinations = Destination::when(Flight::exists(), function($query) {
            return $query->withCount('flights');
        })->latest()->paginate(10);
        return view('administration.gestionnaire.destinations.index', compact('destinations'));
    }

    public function destinationsCreate()
    {
        $pays = [
            'CM' => 'Cameroun',
            'FR' => 'France',
            'US' => 'États-Unis',
            'GB' => 'Royaume-Uni',
            'DE' => 'Allemagne',
            'IT' => 'Italie',
            'ES' => 'Espagne',
            'PT' => 'Portugal',
            'MA' => 'Maroc',
            'SN' => 'Sénégal',
            'CI' => 'Côte d\'Ivoire',
            'GA' => 'Gabon',
            'CG' => 'Congo',
            'BE' => 'Belgique',
            'CH' => 'Suisse',
            'CA' => 'Canada',
        ];

        $timezones = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
        return view('administration.gestionnaire.destinations.create', compact('pays', 'timezones'));
       }
    public function destinationsStore(Request $request)
    {
         
        $validated = $request->validate([
            'ville' => 'required|string|max:255',
            'pays' => 'required|string|max:2',
            'code_aeroport' => 'nullable|string|max:5|unique:destinations',
            'timezone' => 'required|string',
            'description' => 'required|string',
            'image_url' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:planifié,confirmé,annulé',
        ]);

        if ($request->hasFile('image_url')) {
            $image = $request->file('image_url');
            $filename = Str::slug($request->ville) . '-' . time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/destinations', $filename);
            $validated['image_url'] = $filename;
        }

        Destination::create($validated);

        return redirect()
            ->route('manager.destinations.index')
            ->with('success', 'Destination ajoutée avec succès');
    }
    public function destinationsEdit(Destination $destination)
    { 
        $pays = [
            'CM' => 'Cameroun',
            'FR' => 'France',
            'US' => 'États-Unis',
            'GB' => 'Royaume-Uni',
            'DE' => 'Allemagne',
            'IT' => 'Italie',
            'ES' => 'Espagne',
            'PT' => 'Portugal',
            'MA' => 'Maroc',
            'SN' => 'Sénégal',
            'CI' => 'Côte d\'Ivoire',
            'GA' => 'Gabon',
            'CG' => 'Congo',
            'BE' => 'Belgique',
            'CH' => 'Suisse',
            'CA' => 'Canada',
        ];

        $timezones = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
        return view('administration.gestionnaire.destinations.edit', compact('destination', 'pays', 'timezones'));
    }
    public function destinationsUpdate(Request $request, Destination $destination)
    {
        $validated = $request->validate([
            'ville' => 'required|string|max:255',
            'pays' => 'required|string|max:2',
            'code_aeroport' => 'required|string|max:5|unique:destinations,code_aeroport,' . $destination->id,
            'timezone' => 'required|string',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'statut' => 'required|in:actif,inactif',
        ]);

        // Create a data array to update the destination
        $destinationData = [
            'ville' => $validated['ville'],
            'pays' => $validated['pays'],
            'code_aeroport' => $validated['code_aeroport'],
            'timezone' => $validated['timezone'],
            'description' => $validated['description'],
            'statut' => $validated['statut'],
        ];

        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image
            if ($destination->image) {
                Storage::delete('public/destinations/' . $destination->image);
            }

            // Sauvegarder la nouvelle image
            $image = $request->file('image');
            $filename = Str::slug($request->ville) . '-' . time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/destinations', $filename);
            $destinationData['image'] = $filename;
        }

        $destination->update($destinationData);

        return redirect()
            ->route('manager.destinations.index')
            ->with('success', 'Destination mise à jour avec succès');
    }
    // Reservations Management
    public function reservationsList()
    {
        $reservations = Reservation::with(['user', 'flight'])->latest()->paginate(10);
        return view('administration.gestionnaire.reservations.index', compact('reservations'));
    }
    public function reservationsShow(Reservation $reservation)
    {
        return view('administration.gestionnaire.reservations.show', compact('reservation'));
    }
    public function reservationsUpdate(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled',
            'notes' => 'nullable|string',
        ]);
    }
    public function destroy(Destination $destination)
    {
        try {
            // Delete associated image if it exists
            if ($destination->image) {
                Storage::delete('public/destinations/' . $destination->image);
            }

            $destination->delete();
            
            // Add success message to session
            session()->flash('success', 'Destination supprimée avec succès');

            return response()->json([
                'success' => true,
                'message' => 'Destination supprimée avec succès',
                'redirect' => route('manager.destinations.index')
            ]);

        } catch (\Exception $e) {
            session()->flash('error', 'Une erreur est survenue: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression de la destination',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}