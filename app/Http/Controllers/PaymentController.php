<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Reservation $reservation)
    {
        $this->authorize('view', $reservation);

        if ($reservation->payment_status === 'completed') {
            return redirect()->route('reservations.show', $reservation)
                           ->with('info', 'Cette réservation a déjà été payée.');
        }

        return view('site.pages.payments.create', compact('reservation'));
    }

    public function store(Request $request, Reservation $reservation)
    {
        $this->authorize('update', $reservation);

        $request->validate([
            'payment_method' => 'required|in:orange_money,mobile_money,card',
            'phone_number' => 'required_if:payment_method,orange_money,mobile_money|nullable|string',
            'card_number' => 'required_if:payment_method,card|nullable|string',
            'expiry_date' => 'required_if:payment_method,card|nullable|string',
            'cvv' => 'required_if:payment_method,card|nullable|string'
        ]);

        try {
            DB::beginTransaction();

            // Simuler l'intégration avec un service de paiement
            $paymentDetails = $this->processPayment($request, $reservation);

            $payment = Payment::create([
                'reservation_id' => $reservation->id,
                'amount' => $reservation->price_paid,
                'payment_method' => $request->payment_method,
                'transaction_id' => $paymentDetails['transaction_id'],
                'status' => 'completed',
                'payment_details' => $paymentDetails
            ]);

            $reservation->update([
                'status' => 'confirmed',
                'payment_status' => 'completed'
            ]);

            DB::commit();

            return redirect()->route('reservations.show', $reservation)
                           ->with('success', 'Paiement effectué avec succès !');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Une erreur est survenue lors du paiement.');
        }
    }

    private function processPayment($request, $reservation)
    {
        // Simulation du traitement du paiement
        // En production, intégrer de vrais services de paiement ici
        return [
            'transaction_id' => 'TXN_' . uniqid(),
            'amount' => $reservation->price_paid,
            'currency' => 'XAF',
            'payment_method' => $request->payment_method,
            'status' => 'success',
            'timestamp' => now()->toIso8601String()
        ];
    }
}
