<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DialogflowController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Groupe de routes pour Dialogflow avec gestion CORS
Route::prefix('v1')->middleware(['cors'])->group(function () {
    // Webhook Dialogflow
    Route::post('/dialogflow-webhook', [DialogflowController::class, 'handle']);
    
    // Endpoint de chat direct pour le widget de chat
    Route::post('/chat', [DialogflowController::class, 'chat']);
    
    // Nouvel endpoint pour le chat avec Open Router
    Route::post('/openrouter/chat', [\App\Http\Controllers\Api\ChatController::class, 'sendMessage']);
    
    // Gestion des requêtes OPTIONS pour CORS
    Route::options('/{any}', function () {
        return response('', 200)
            ->header('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE')
            ->header('Access-Control-Allow-Headers', 'Content-Type, X-Auth-Token, Origin, Authorization');
    })->where('any', '.*');
});
