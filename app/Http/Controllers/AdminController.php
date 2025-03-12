<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Flight;
use App\Models\Destination;
use App\Models\Reservation;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'users_count' => User::count(),
            'flights_count' => Flight::count(),
            'reservations_count' => Reservation::count(),
            'destinations_count' => Destination::count(),
        ];
        
        return view('admin.dashboard', compact('stats'));
    }

    // Flights Management
    public function flightsList()
    {
        $flights = Flight::with(['destination'])->latest()->paginate(10);
        return view('admin.flights.index', compact('flights'));
    }

    public function flightsCreate()
    {
        $destinations = Destination::all();
        return view('admin.flights.create', compact('destinations'));
    }

    public function flightsStore(Request $request)
    {
        $validated = $request->validate([
            'flight_number' => 'required|unique:flights',
            'departure_city' => 'required',
            'destination_id' => 'required|exists:destinations,id',
            'departure_time' => 'required|date',
            'arrival_time' => 'required|date|after:departure_time',
            'price' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
        ]);

        Flight::create($validated);
        return redirect()->route('admin.flights.index')->with('success', 'Vol créé avec succès');
    }

    public function flightsEdit(Flight $flight)
    {
        $destinations = Destination::all();
        return view('admin.flights.edit', compact('flight', 'destinations'));
    }

    public function flightsUpdate(Request $request, Flight $flight)
    {
        $validated = $request->validate([
            'flight_number' => 'required|unique:flights,flight_number,' . $flight->id,
            'departure_city' => 'required',
            'destination_id' => 'required|exists:destinations,id',
            'departure_time' => 'required|date',
            'arrival_time' => 'required|date|after:departure_time',
            'price' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
        ]);

        $flight->update($validated);
        return redirect()->route('admin.flights.index')->with('success', 'Vol mis à jour avec succès');
    }

    public function flightsDestroy(Flight $flight)
    {
        $flight->delete();
        return redirect()->route('admin.flights.index')->with('success', 'Vol supprimé avec succès');
    }

    // Users Management
    public function usersList()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function usersShow(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function usersEdit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function usersUpdate(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:user,manager,admin',
        ]);

        $user->update($validated);
        return redirect()->route('admin.users.index')->with('success', 'Utilisateur mis à jour avec succès');
    }

    public function usersDelete(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Utilisateur supprimé avec succès');
    }

    // Autres méthodes existantes...
}