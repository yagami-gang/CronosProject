<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OpenRouterService
{
    protected $apiKey;
    protected $apiUrl = 'https://openrouter.ai/api/v1/chat/completions';
    protected $model = 'openrouter/cypher-alpha:free';

    public function __construct()
    {
        $this->apiKey = config('services.openrouter.api_key');
    }

    public function sendMessage($message, $context = [])
    {
        try {
            $messages = [
                [
                    'role' => 'system',
                    'content' => 'Vous êtes un assistant virtuel pour une application de réservation de vols.\n' .
                    'Votre rôle est d\'aider les utilisateurs à trouver des vols et à gérer leurs réservations.\n' .
                    'Pour les questions sur les vols disponibles, répondez brièvement et laissez le système gérer l\'affichage des résultats.\n' .
                    'Les utilisateurs peuvent poser des questions sur :\n' .
                    '- Les vols disponibles à une date précise (ex: "Quels vols avez-vous demain ?")\n' .
                    '- Les vols vers une destination spécifique (ex: "Je veux aller à Paris")\n' .
                    '- Les détails d\'un vol spécifique (ex: "Donnez-moi les détails du vol AF123")\n' .
                    '- L\'état de leurs réservations (ex: "Quels sont mes vols à venir ?")\n\n' .
                    'Si un utilisateur pose une question sur les vols disponibles, répondez simplement par "Je vais chercher les vols disponibles...".\n' .
                    'Le système détectera automatiquement les critères de recherche et affichera les résultats appropriés.'
                ],
                [
                    'role' => 'user',
                    'content' => $message
                ]
            ];

            $response =Http::withOptions([
                'verify' => false, // désactive la vérification SSL
            ])->withHeaders([
                'Authorization' => 'Bearer ' . env('OPENROUTER_API_KEY'),
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post($this->apiUrl, [
                'model' => $this->model,
                'messages' => $messages,
                'temperature' => 0.7,
                'max_tokens' => 500,
            ]);

            if ($response->successful()) {
                return $response->json()['choices'][0]['message']['content'];
            }

            Log::error('OpenRouter API Error: ' . $response->body());
            return 'Désolé, une erreur est survenue lors du traitement de votre demande.';

        } catch (\Exception $e) {
            Log::error('OpenRouter Service Error: ' . $e->getMessage());
            return 'Désolé, le service est temporairement indisponible.';
        }
    }
}
