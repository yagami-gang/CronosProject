<?php

namespace App\Helpers;

use Monetbil\Monetbil;

class PaymentHelper
{
    public static function initPayment($amount, $reservationId, $user, $returnUrl)
    {
        $paymentData = [
            'amount' => $amount,
            'currency' => 'XAF',
            'item_ref' => 'RES-' . $reservationId,
            'payment_ref' => 'PAY-' . time() . '-' . $reservationId,
            'user' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'country' => 'CM',
            'return_url' => $returnUrl . '?success=1',
            'notify_url' => route('payment.monetbil.webhook'),
            'cancel_url' => $returnUrl . '?cancel=1'
        ];

        return Monetbil::createPayment($paymentData);
    }

    public static function verifyPayment($paymentId)
    {
        return Monetbil::verifyPayment($paymentId);
    }
}
