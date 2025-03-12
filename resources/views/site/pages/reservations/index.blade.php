@extends('site.layouts.app')

@section('content')
<div class="min-h-screen pt-20 bg-gray-50">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 py-8">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="text-white mb-6 md:mb-0">
                    <h1 class="text-4xl font-bold mb-2">Mes Voyages</h1>
                    <p class="text-blue-100">Gérez vos réservations et planifiez vos prochaines aventures</p>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('flights.search') }}" class="flex items-center bg-white text-blue-600 px-6 py-3 rounded-lg hover:bg-blue-50 transition duration-300">
                        <i class="fas fa-search mr-2"></i>
                        Rechercher un vol
                    </a>
                    <a href="#stats" class="flex items-center bg-blue-700 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition duration-300">
                        <i class="fas fa-chart-line mr-2"></i>
                        Mes statistiques
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center">
                    <div class="bg-blue-100 rounded-full p-3">
                        <i class="fas fa-plane-departure text-blue-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm">Vols à venir</p>
                        <h3 class="text-2xl font-bold text-gray-800">{{ $upcomingFlights ?? 0 }}</h3>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center">
                    <div class="bg-green-100 rounded-full p-3">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm">Vols complétés</p>
                        <h3 class="text-2xl font-bold text-gray-800">{{ $completedFlights ?? 0 }}</h3>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center">
                    <div class="bg-purple-100 rounded-full p-3">
                        <i class="fas fa-map-marked-alt text-purple-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm">Destinations</p>
                        <h3 class="text-2xl font-bold text-gray-800">{{ $uniqueDestinations ?? 0 }}</h3>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center">
                    <div class="bg-yellow-100 rounded-full p-3">
                        <i class="fas fa-coins text-yellow-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm">Points fidélité</p>
                        <h3 class="text-2xl font-bold text-gray-800">{{ number_format($loyaltyPoints ?? 0) }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reservations List -->
        @if($reservations->isEmpty())
            <div class="bg-white rounded-xl shadow-sm p-12 text-center border border-gray-100">
                <img src="{{ asset('images/empty-reservations.svg') }}" alt="Aucune réservation" class="w-64 mx-auto mb-6">
                <h4 class="text-2xl font-bold text-gray-800 mb-4">Commencez votre voyage</h3>
                <p class="text-gray-600 mb-8 max-w-md mx-auto">Découvrez nos destinations et réservez votre prochain vol en quelques clics !</p>
                <a href="{{ route('flights.search') }}" class="inline-flex items-center bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition duration-300">
                    <i class="fas fa-paper-plane mr-2"></i>
                    Explorer les destinations
                </a>
            </div>
        @else
            <!-- Filtres -->
            <div class="bg-white rounded-xl shadow-sm p-4 mb-6 border border-gray-100">
                <div class="flex flex-wrap items-center gap-4">
                    <span class="text-gray-700 font-medium">Filtrer par :</span>
                    <button class="px-4 py-2 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 transition">
                        Tous ({{ $reservations->count() ?? 0 }})
                    </button>
                    <button class="px-4 py-2 rounded-lg hover:bg-gray-100 transition">
                        À venir ({{ $upcomingFlights ?? 0 }})
                    </button>
                    <button class="px-4 py-2 rounded-lg hover:bg-gray-100 transition">
                        Complétés ({{ $completedFlights ?? 0 }})
                    </button>
                    <div class="ml-auto">
                        <input type="text" placeholder="Rechercher une réservation..." 
                               class="px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
            </div>

            <!-- Liste des réservations -->
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach($reservations as $reservation)
                    <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition duration-300 border border-gray-100 overflow-hidden">
                        <!-- En-tête avec statut -->
                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
                            <div class="flex justify-between items-center">
                                <span class="px-3 py-1 rounded-full text-sm font-medium {{ 
                                    match($reservation->status) {
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'confirmed' => 'bg-green-100 text-green-800',
                                        'completed' => 'bg-blue-100 text-blue-800',
                                        'cancelled' => 'bg-red-100 text-red-800',
                                        default => 'bg-gray-100 text-gray-800'
                                    }
                                }}">
                                    {{ match($reservation->status) {
                                        'pending' => 'En attente',
                                        'confirmed' => 'Confirmée',
                                        'completed' => 'Terminée',
                                        'cancelled' => 'Annulée',
                                        default => ucfirst($reservation->status ?? 'Statut inconnu')
                                    } }}
                                </span>
                                <span class="text-gray-500 text-sm">
                                    <i class="far fa-calendar-alt mr-1"></i>
                                    {{ $reservation->created_at ? $reservation->created_at->format('d/m/Y') : 'Date inconnue' }}
                                </span>
                            </div>
                        </div>

                        <!-- Informations du vol -->
                        <div class="p-6">
                            <!-- Destination et date -->
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center">
                                    <div class="bg-blue-50 rounded-full p-2 mr-3">
                                        <i class="fas fa-map-marker-alt text-blue-600"></i>
                                    </div>
                                    <div>
                                        <div class="text-sm text-gray-500">Destination</div>
                                        <div class="font-medium">{{ $reservation->flight->destination->ville ?? 'N/A' }}, {{ $reservation->flight->destination->pays ?? '' }}</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-sm text-gray-500">Date de voyage</div>
                                    <div class="font-medium">{{ isset($reservation->travel_date) ? \Carbon\Carbon::parse($reservation->travel_date)->format('d M Y') : 'N/A' }}</div>
                                </div>
                            </div>
                            
                            <!-- Trajet -->
                            <div class="flex items-center mb-6 bg-gray-50 p-3 rounded-lg">
                                <div class="flex-1">
                                    <div class="text-lg font-semibold text-gray-800">{{ $reservation->flight->departure_city ?? 'N/A' }}</div>
                                    <div class="text-sm text-gray-500">{{ $reservation->flight->departure_time ? $reservation->flight->departure_time->format('H:i') : 'N/A' }}</div>
                                </div>
                                <div class="px-4">
                                    <div class="w-20 h-px bg-gray-300 relative">
                                        <i class="fas fa-plane text-blue-600 absolute -top-2 left-1/2 transform -translate-x-1/2"></i>
                                    </div>
                                    <div class="text-xs text-gray-500 text-center mt-2">{{ $reservation->flight->duration ?? 0 }} min</div>
                                </div>
                                <div class="flex-1 text-right">
                                    <div class="text-lg font-semibold text-gray-800">{{ $reservation->flight->arrival_city ?? 'N/A' }}</div>
                                    <div class="text-sm text-gray-500">{{ $reservation->flight->arrival_time ? $reservation->flight->arrival_time->format('H:i') : 'N/A' }}</div>
                                </div>
                            </div>

                            <!-- Détails de la réservation -->
                            <div class="space-y-3 border-t border-gray-100 pt-4">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">N° de vol</span>
                                    <span class="font-medium">{{ $reservation->flight->flight_number ?? 'N/A' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Passagers</span>
                                    <span class="font-medium">{{ $reservation->seat_number ?? $reservation->seat_number ?? 0 }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Classe</span>
                                    <span class="font-medium">{{ $reservation->seat_class ?? 'Économique' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Total</span>
                                    <span class="font-bold text-lg">{{ number_format($reservation->price_paid ?? 0, 0, ',', ' ') }} FCFA</span>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="bg-gray-50 px-6 py-4 border-t border-gray-100">
                            <div class="flex justify-between items-center">
                                <a href="{{ route('reservations.show', $reservation) }}" 
                                   class="text-blue-600 hover:text-blue-800 font-medium flex items-center">
                                    <span>Voir les détails</span>
                                    <i class="fas fa-chevron-right ml-2"></i>
                                </a>
                                @if($reservation->can_cancel ?? false)
                                    <form action="{{ route('reservations.cancel', $reservation) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="text-red-600 hover:text-red-800 font-medium"
                                                onclick="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?')">
                                            <i class="fas fa-times mr-1"></i> Annuler
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $reservations->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Animation pour les statistiques
    document.addEventListener('DOMContentLoaded', function() {
        const stats = document.querySelectorAll('.text-2xl');
        stats.forEach(stat => {
            const value = parseInt(stat.textContent ?? 0);
            let current = 0;
            const increment = value / 30;
            const timer = setInterval(() => {
                current += increment;
                if (current >= value) {
                    clearInterval(timer);
                    current = value;
                }
                stat.textContent = Math.round(current);
            }, 50);
        });
    });
</script>
@endpush