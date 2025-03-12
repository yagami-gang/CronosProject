<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use Illuminate\Http\Request;

class FlightController extends Controller
{
    public function search(Request $request)
    {
        $flights = Flight::query()
            ->when($request->departure, function($query, $departure) {
                return $query->where('departure', $departure);
            })
            ->when($request->destination, function($query, $destination) {
                return $query->where('destination', $destination);
            })
            ->when($request->date, function($query, $date) {
                return $query->whereDate('departure_time', $date);
            })
            ->when($request->price_max, function($query, $price) {
                return $query->where('price', '<=', $price);
            })
            ->paginate(10);

        return view('site.pages.flights.search', [
            'flights' => $flights,
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
