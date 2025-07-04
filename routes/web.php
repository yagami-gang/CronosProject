<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\ReservationController;



Auth::routes();
Route::redirect('/', '/home');
// Page d'accueil
Route::get('/home', function() {
    return view('site.home');
})->name('home');
// Routes pour les vols
Route::get('/flights/search', [FlightController::class, 'search'])->name('flights.search');
Route::get('/flights/{flight}', [FlightController::class, 'show'])->name('flights.show');

// Routes pour les destinations
Route::get('/public/destination', [DestinationController::class, 'index'])->name('public.destinations');
Route::get('/public/destinations/{destination}', [DestinationController::class, 'show'])->name('destinations.show');

// Routes protégées par authentification
Route::middleware(['auth'])->group(function () {
    // Profil utilisateur
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/password', [ProfileController::class, 'passwordGet'])->name('profile.password.get');
    Route::post('/profile/password', [ProfileController::class, 'passwordPost'])->name('profile.password.post');
    Route::post('/payment/initiate', [PaymentController::class, 'initiatePayment'])->name('payment.initiate');
    Route::get('/payment/return/{reservation}', [PaymentController::class, 'handleReturn'])->name('payment.return');
    Route::get('/payment/cancel/{reservation}', [PaymentController::class, 'handleCancel'])->name('payment.cancel');
    // Webhook pour les notifications de paiement
        Route::post('/payment/webhook', [PaymentController::class, 'handleWebhook'])
        ->name('payment.webhook');
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/reservations/create/{flight}', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
    Route::get('/reservations/{reservation}', [ReservationController::class, 'show'])->name('reservations.show');
    Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy'])->name('reservations.destroy');
    // Ajouter cette route avec les autres routes de réservation
    Route::post('/reservations/quick-store', [App\Http\Controllers\ReservationController::class, 'quickStore'])->name('reservations.quick-store')->middleware('auth');
});
// Admin routes protected by authentication and admin middleware
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Flights management
    Route::get('/flights', [AdminController::class, 'flightsList'])->name('admin.flights.index');
    Route::get('/flights/create', [AdminController::class, 'flightsCreate'])->name('admin.flights.create');
    Route::post('/flights', [AdminController::class, 'flightsStore'])->name('admin.flights.store');
    Route::get('/flights/{flight}/edit', [AdminController::class, 'flightsEdit'])->name('admin.flights.edit');
    Route::put('/flights/{flight}', [AdminController::class, 'flightsUpdate'])->name('admin.flights.update');
    Route::delete('/flights/{flight}', [AdminController::class, 'flightsDestroy'])->name('admin.flights.destroy');

    // Destinations management
    Route::get('/destinations', [AdminController::class, 'destinationsList'])->name('admin.destinations.index');
    Route::get('/destinations/create', [AdminController::class, 'destinationsCreate'])->name('admin.destinations.create');
    Route::post('/destinations/store', [AdminController::class, 'destinationsStore'])->name('admin.destinations.store');
    Route::get('/destinations/{destination}/edit', [AdminController::class, 'destinationsEdit'])->name('admin.destinations.edit');
    Route::put('/destinations/{destination}', [AdminController::class, 'destinationsUpdate'])->name('admin.destinations.update');
    Route::delete('/destinations/{destination}/delete', [AdminController::class, 'destinationsDestroy'])->name('admin.destinations.destroy');

    // Reservations management
    Route::get('/reservations', [AdminController::class, 'reservationsList'])->name('admin.reservations.index');
    Route::get('/reservations/{reservation}', [AdminController::class, 'reservationsShow'])->name('admin.reservations.show');
    Route::put('/reservations/{reservation}', [AdminController::class, 'reservationsUpdate'])->name('admin.reservations.update');
    Route::delete('/reservations/{reservation}', [AdminController::class, 'reservationsDestroy'])->name('admin.reservations.destroy');

    // Users management
    Route::get('/users', [AdminController::class, 'usersList'])->name('admin.users.index');
    Route::get('/users/{user}', [AdminController::class, 'usersShow'])->name('admin.users.show');
    Route::get('/users/{user}/edit', [AdminController::class, 'usersEdit'])->name('admin.users.edit');
    Route::put('/users/{user}', [AdminController::class, 'usersUpdate'])->name('admin.users.update');
    Route::delete('/users/{user}', [AdminController::class, 'usersDelete'])->name('admin.users.destroy');
});

// Manager routes protected by authentication and manager middleware
Route::middleware(['auth', 'manager'])->prefix('manager')->group(function () {
    // Dashboard
    Route::get('/dashboard', [ManagerController::class, 'dashboard'])->name('manager.dashboard');

    // Flights management
    Route::resource('flights', FlightController::class)->names([
        'index' => 'manager.flights.index',
        'create' => 'manager.flights.create',
        'store' => 'manager.flights.store',
        'show' => 'manager.flights.show',
        'edit' => 'manager.flights.edit',
        'update' => 'manager.flights.update',
        'destroy' => 'manager.flights.destroy',
    ]);

    // Destinations management
    Route::resource('destinations', DestinationController::class)->names([
        'index' => 'manager.destinations.index',
        'create' => 'manager.destinations.create',
        'store' => 'manager.destinations.store',
        'show' => 'manager.destinations.show',
        'edit' => 'manager.destinations.edit',
        'update' => 'manager.destinations.update',
        'destroy' => 'manager.destinations.destroy',
    ]);

    // Reservations management
    Route::resource('reservations', ManagerController::class)->names([
        'index' => 'manager.reservations.index',
        'show' => 'manager.reservations.show',
        'update' => 'manager.reservations.update',
    ]);
});


