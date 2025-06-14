<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use App\Models\Destination;
use Illuminate\Http\Request;

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

    public function show(Flight $flight)
    {
        return view('site.pages.flights.show', [
            'flight' => $flight->load('availableSeats')
        ]);
    }
}
