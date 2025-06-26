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
        $destinations = Destination::when(Flight::exists(), function($query) {
            return $query->withCount('flights');
        })->latest()->paginate(10);
        return view('administration.manager.destinations.index', compact('destinations'));
    }

    public function create()
    {
        $pays = [
             'CM' => 'Cameroun',
            // 'FR' => 'France',
            // 'US' => 'États-Unis',
            // 'GB' => 'Royaume-Uni',
            // 'DE' => 'Allemagne',
            // 'IT' => 'Italie',
            // 'ES' => 'Espagne',
            // 'PT' => 'Portugal',
            // 'MA' => 'Maroc',
            // 'SN' => 'Sénégal',
            // 'CI' => 'Côte d\'Ivoire',
            // 'GA' => 'Gabon',
            // 'CG' => 'Congo',
            // 'BE' => 'Belgique',
            // 'CH' => 'Suisse',
            // 'CA' => 'Canada',
        ];

        $timezones = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
        return view('administration.manager.destinations.create', compact('pays', 'timezones'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ville' => 'required|string|max:255',
            'pays' => 'required|string|max:2',
            'description' => 'required|string',
            'image_url' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'statut' => 'required|in:actif,inactif',
            'populaire' => 'nullable|boolean',
            'note' => 'nullable|numeric|min:0|max:5',
        ]);
    
        // Handle the checkbox
        $validated['populaire'] = $request->has('populaire');
    
        // Handle file upload
        if ($request->hasFile('image_url')) {
            $image = $request->file('image_url');
            $filename = Str::slug($request->ville) . '-' . time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/destinations', $filename);
            $validated['image_url'] = 'destinations/' . $filename;
        }
    
        // Create the destination with validated data
        Destination::create($validated);
    
        return redirect()
            ->route('manager.destinations.index')
            ->with('success', 'Destination ajoutée avec succès');
    }

    public function edit(Destination $destination)
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
        return view('administration.manager.destinations.edit', compact('destination', 'pays', 'timezones'));
    }

    public function update(Request $request, Destination $destination)
    {
        $validated = $request->validate([
            'ville' => 'required|string|max:255',
            'pays' => 'required|string|max:2',
            'description' => 'required|string',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'statut' => 'required|in:actif,inactif',
            'populaire' => 'nullable|boolean',
            'note' => 'nullable|numeric|min:0|max:5',
        ]);

        // Handle the checkbox
        $validated['populaire'] = $request->has('populaire');

        // Handle file upload if a new image is provided
        if ($request->hasFile('image_url')) {
            // Delete old image if it exists
            if ($destination->image_url) {
                Storage::delete('public/' . $destination->image_url);
            }

            // Save the new image
            $image = $request->file('image_url');
            $filename = Str::slug($validated['ville']) . '-' . time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/destinations', $filename);
            $validated['image_url'] = 'destinations/' . $filename;
        } else {
            // Keep the existing image if no new one is uploaded
            unset($validated['image_url']);
        }

        // Update the destination with validated data
        $destination->update($validated);

        return redirect()
            ->route('manager.destinations.index')
            ->with('success', 'Destination mise à jour avec succès');
    }

    

    public function show(Destination $destination)
    {
        return view('administration.manager.destinations.show', compact('destination'));
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