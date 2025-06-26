<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use App\Models\Reservation;
use App\Models\Destination;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    

    public function index()
    {
        $reservations = Reservation::with(['user', 'flight'])->latest()->paginate(10);
        return view('administration.manager.reservations.index', compact('reservations'));
    }

    /**
     * Display the manager dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        $stats = [
            'flights_count' => Flight::count(),
            'reservations_count' => Reservation::count(),
            'destinations_count' => Destination::count(),
            'recent_reservations' => Reservation::with(['user', 'flight'])->latest()->take(5)->get(),
        ];
        
        $totalDestinations = Destination::count();
        $totalVols = Flight::count();
        $destinationsActives = Destination::where('statut', 'actif')->count();
        $volsPlanifies = Flight::where('status', 'planifié')->count();
        
        return view('administration.manager.dashboard', compact(
            'stats',
            'totalDestinations',
            'totalVols',
            'destinationsActives',
            'volsPlanifies'
        ));
    }

    
    public function show(Reservation $reservation)
    {
        return view('administration.manager.reservations.show', compact('reservation'));
    }


}