<?php

namespace App\Http\Controllers;

use DateTimeZone;
use App\Models\Flight;
use App\Models\Destination;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DestinationController extends Controller
{
    public function index()
    {
        $destinations = Destination::latest()->paginate(10);
        $flights = Flight::latest()->paginate(10);
        return view('site.pages.destination.destinations', compact('destinations','flights'));
    }

    public function create()
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
        return view('administration.manager.destinations.create', compact('pays', 'timezones'));
    }

    public function store(Request $request)
    {
       
    }

    public function edit(Destination $destination)
    {
       
    }

    public function update(Request $request, Destination $destination)
    {
       
    }

    

    public function show(Destination $destination)
    {
        return view('administration.manager.destinations.show', compact('destination'));
    }
}