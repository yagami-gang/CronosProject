<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Services\MonetbilService;

class PaymentController extends Controller
{
    protected $monetbilService;

    public function __construct(MonetbilService $monetbilService)
    {
        $this->monetbilService = $monetbilService;
    }

    public function initiatePayment(Request $request)
    {
        $request->validate([
            'flight_id' => 'required|exists:flights,id',
            'passengers_count' => 'required|integer|min:1',
            'travel_date' => 'required|date',
            'amount' => 'required|numeric',
            'item_name' => 'required|string'
        ]);

        try {
            // Créer une réservation en attente de paiement
            $reservation = Reservation::create([
                'user_id' => auth()->id(),
                'flight_id' => $request->flight_id,
                'passengers_count' => $request->passengers_count,
                'travel_date' => $request->travel_date,
                'price_paid' => $request->amount,
                'status' => 'pending',
                'payment_status' => 'pending',
            ]);

            // Initialiser le paiement Monetbil
            $paymentData = [
                'amount' => (string) $request->amount, // Monetbil attend souvent des chaînes pour les montants
                'item_ref' => 'RES-' . $reservation->id,
                'payment_ref' => 'PAY-' . time() . '-' . $reservation->id,
                'user' => (string) auth()->id(),
                'email' => auth()->user()->email,
                'return_url' => route('payment.return', ['reservation' => $reservation->id]),
                'notify_url' => route('payment.webhook'),
                'cancel_url' => route('payment.cancel', ['reservation' => $reservation->id]),
                'first_name' => auth()->user()->first_name ?? 'Client',
                'last_name' => auth()->user()->last_name ?? 'Anonyme',
                'item_name' => $request->item_name
            ];

             // Obtenir le payload signé de notre service
        $signedPaymentData = $this->monetbilService->initiatePayment($paymentData);
        
        // Retourner ce payload au format JSON
        return response()->json([
            'success' => true,
            'payment_data' => $signedPaymentData // <- Le changement clé !
        ]);

        } catch (\Exception $e) {
            \Log::error('Payment Initiation Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'initialisation du paiement'
            ], 500);
        }
    }

    public function handleReturn(Request $request, $reservationId)
    {
        $reservation = Reservation::findOrFail($reservationId);
        
        if ($reservation->status === 'paid') {
            return redirect()->route('reservations.show', $reservation)
                ->with('success', 'Paiement effectué avec succès !');
        }

        return redirect()->route('reservations.show', $reservation)
            ->with('warning', 'Votre paiement est en cours de traitement.');
    }

    public function handleWebhook(Request $request)
    {
        $paymentId = $request->input('paymentId');
        $paymentStatus = $this->monetbilService->verifyPayment($paymentId);

        $transaction = $paymentStatus['transaction'];
        $itemRef = $transaction['item_ref'] ?? '';
        
        // Extraire l'ID de réservation (format: RES-123)
        $reservationId = str_replace('RES-', '', $itemRef);
        $reservation = Reservation::find($reservationId);
        
        if (!$reservation) {
            \Log::error('Réservation non trouvée', ['id' => $reservationId]);
            return response()->json(['error' => 'Réservation non trouvée'], 404);
        }
        
        // Mettre à jour selon le statut
        if ($transaction['status'] === 'SUCCESS') {
            $reservation->update([
                'status' => 'confirmed',
                'payment_status' => 'payment_status',
                'paid_at' => now(),
                'payment_reference' => $transaction['id']
            ]);
            
             Mail::to($reservation->user->email)->send(new ReservationConfirmed($reservation));
            
        } elseif (in_array($transaction['status'], ['FAILED', 'EXPIRED'])) {
            $reservation->update([
                'status' => 'cancelled',
                'payment_status' => 'failed',
                'cancelled_at' => now()
            ]);
            
             Mail::to($reservation->user->email)->send(new PaymentFailed($reservation));
        }
        
        return response()->json(['status' => 'success']);
    }
}