<?php

namespace App\Services;

class MonetbilService
{
    protected $serviceKey;
    protected $secretKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->serviceKey = env('MONETBIL_SERVICE_KEY');
        $this->secretKey = env('MONETBIL_SECRET_KEY');
        $this->baseUrl = 'https://api.monetbil.com/widget/v2.1/';
    }

    public function initiatePayment(array $data)
    {
        $data = array_merge([
            'service' => $this->serviceKey,
            'amount' => $data['amount'],
            'currency' => $data['currency'] ?? 'XAF',
            'item_ref' => $data['item_ref'],
            'payment_ref' => $data['payment_ref'],
            'country' => $data['country'] ?? 'CM',
            'return_url' => $data['return_url'],
            'notify_url' => $data['notify_url'],
            'cancel_url' => $data['cancel_url'],
            'user' => $data['user'],
            'first_name' => $data['first_name'] ?? null,
            'last_name' => $data['last_name'] ?? null,
            'email' => $data['email'] ?? null,
            'item_name' => $data['item_name'] ?? 'Paiement',
        ]);

        $data['signature'] = $this->generateSignature($data);
        
        // Construire l'URL de paiement avec tous les paramètres
        $paymentUrl = $this->baseUrl . $this->serviceKey;
        
        return $paymentUrl;
    }

    public function verifyPayment($paymentId)
    {
        $response = $this->makeRequest('/check', ['paymentId' => $paymentId]);
        return $response;
    }

    protected function generateSignature($data)
    {
        ksort($data);
        $signature = '';
        foreach ($data as $key => $value) {
            if ($value !== null && $value !== '') {
                $signature .= $key . '=' . $value . '&';
            }
        }
        $signature .= $this->secretKey;
        return md5($signature);
    }

    protected function makeRequest($endpoint, $data)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->baseUrl . $endpoint);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            throw new \Exception("cURL Error: " . $error);
        }

        return json_decode($response, true) ?: [];
    }
}