<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Flight $flight)
    {
        return view('site.pages.reservations.create', compact('flight'));
    }

    public function store(Request $request, Flight $flight)
    {
        $request->validate([
            'seat_number' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            if ($flight->available_seats <= 0) {
                return back()->with('error', 'Désolé, ce vol est complet.');
            }

            $reservation = Reservation::create([
                'user_id' => auth()->id(),
                'flight_id' => $flight->id,
                'seat_number' => $request->seat_number,
                'price_paid' => $flight->price,
                'status' => 'pending',
                'payment_status' => 'pending'
            ]);

            $flight->decrement('available_seats');

            DB::commit();

            return redirect()->route('payments.create', $reservation)
                           ->with('success', 'Réservation créée avec succès. Procédez au paiement.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Une erreur est survenue lors de la réservation.');
        }
    }

    public function index()
    {
        $reservations = auth()->user()->reservations()
                                    ->with('flight')
                                    ->latest()
                                    ->paginate(10);

        return view('site.pages.reservations.index', compact('reservations'));
    }

    public function show(Reservation $reservation)
    {
        $this->authorize('view', $reservation);
        
        return view('site.pages.reservations.show', compact('reservation'));
    }

    public function cancel(Reservation $reservation)
    {
        $this->authorize('update', $reservation);

        if ($reservation->status !== 'pending') {
            return back()->with('error', 'Cette réservation ne peut plus être annulée.');
        }

        try {
            DB::beginTransaction();

            $reservation->update(['status' => 'cancelled']);
            $reservation->flight->increment('available_seats');

            DB::commit();

            return back()->with('success', 'Réservation annulée avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Une erreur est survenue lors de l\'annulation.');
        }
    }

    /**
     * Traite une réservation rapide depuis la page des destinations.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function quickStore(Request $request)
    {
        try {
            // Valider les données
            $validated = $request->validate([
                'flight_id' => 'required|exists:flights,id',
                'passengers_count' => 'required|integer|min:1|max:5',
                'price_paid' => 'required|numeric|min:0',
                'travel_date' => 'required|date|after:today',
                'seat_number' => 'required|string',
            ]);
            
            // Récupérer le vol
            $flight = \App\Models\Flight::findOrFail($validated['flight_id']);
            
            // Vérifier la disponibilité des sièges
            if ($flight->available_seats < $validated['passengers_count']) {
                return response()->json([
                    'success' => false,
                    'message' => 'Désolé, il n\'y a pas assez de sièges disponibles pour cette réservation.'
                ], 400);
            }
            
            // Calculer le montant total
            $totalAmount = $flight->price * $validated['passengers_count'];
            
            // Générer une référence unique
            $reference = 'RES-' . strtoupper(substr(md5(uniqid()), 0, 8));
            
            // Créer la réservation
            $reservation = \App\Models\Reservation::create([
                'user_id' => auth()->id(),
                'flight_id' => $validated['flight_id'],
                'reference' => $reference,
                'passengers_count' => $validated['passengers_count'],
                'seat_number' => $validated['seat_number'],
                'travel_date' => $validated['travel_date'],
                'price_paid' => $totalAmount,
                'status' => 'pending',
            ]);
            
            // Mettre à jour les sièges disponibles
            $flight->available_seats -= $validated['passengers_count'];
            $flight->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Votre réservation a été enregistrée avec succès! Référence: ' . $reference,
                'reservation' => $reservation
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue: ' . $e->getMessage()
            ], 500);
        }
    }
}
