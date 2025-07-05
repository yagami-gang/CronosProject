@forelse ($flights ?? [] as $flight)
    <div class="overflow-hidden mb-6 bg-white rounded-lg shadow-md transition-shadow duration-300 hover:shadow-lg">
        <div class="p-4 sm:p-6">
            <!-- En-tête - Informations principales -->
            <div class="flex flex-col justify-between space-y-4 sm:space-y-0 sm:flex-row">
                <!-- Départ -->
                <div class="flex-1">
                    <div class="text-lg font-bold text-gray-900 sm:text-xl">{{ $flight->villeDepart->ville ?? 'N/A' }}</div>
                    <div class="text-sm text-gray-500">{{ ($flight->departure_time ?? now())->format('d M Y, H:i') }}</div>
                </div>

                <!-- Durée du vol -->
                <div class="flex justify-center items-center my-2 sm:my-0 sm:mx-4">
                    <div class="relative w-full">
                        <div class="flex absolute inset-0 items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="flex relative justify-center">
                            <span class="px-2 text-sm text-gray-500 bg-white">
                                {{ ($flight->arrival_time ?? now())->diffInHours($flight->departure_time ?? now()) }}h
                                {{ ($flight->arrival_time ?? now())->diffInMinutes($flight->departure_time ?? now()) % 60 }}m
                            </span>
                        </div>
                    </div>
                    <i class="ml-2 text-blue-500 fas fa-plane"></i>
                </div>

                <!-- Destination -->
                <div class="flex-1 text-right">
                    <div class="text-lg font-bold text-gray-900 sm:text-xl">{{ $flight->destination->ville ?? 'N/A' }}</div>
                    <div class="text-sm text-gray-500">{{ ($flight->arrival_time ?? now())->format('d M Y, H:i') }}</div>
                </div>

                <!-- Prix -->
                <div class="flex flex-col justify-center items-end mt-4 sm:mt-0 sm:ml-6">
                    <div class="text-2xl font-bold text-blue-600">{{ number_format($flight->price ?? 0, 0, ',', ' ') }} <span class="text-sm">FCFA</span></div>
                    <div class="text-xs text-gray-500">Prix par personne</div>
                </div>
            </div>

            <!-- Détails du vol -->
            <div class="pt-4 mt-6 border-t border-gray-100">
                <div class="flex flex-wrap gap-3 justify-between items-center">
                    <!-- Badges d'information -->
                    <div class="flex flex-wrap gap-2 items-center">
                        @if(($flight->available_seats ?? 0) > 0)
                        <span class="inline-flex items-center px-3 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full">
                            <i class="mr-1 text-green-500 fas fa-check-circle"></i>
                            {{ $flight->available_seats }} places
                        </span>
                        @else
                        <span class="inline-flex items-center px-3 py-1 text-xs font-medium text-red-800 bg-red-100 rounded-full">
                            <i class="mr-1 text-red-500 fas fa-times-circle"></i>
                            Complet
                        </span>
                        @endif

                        <span class="inline-flex items-center px-3 py-1 text-xs font-medium text-blue-800 bg-blue-100 rounded-full">
                            <i class="mr-1 text-blue-500 fas fa-couch"></i>
                            {{ $flight->class ?? 'Économique' }}
                        </span>

                        <span class="inline-flex items-center px-3 py-1 text-xs font-medium text-purple-800 bg-purple-100 rounded-full">
                            <i class="mr-1 text-purple-500 fas fa-plane"></i>
                            {{ $flight->flight_number ?? 'N/A' }}
                        </span>
                    </div>

                    <!-- Bouton d'action -->
                    <div class="mt-3 w-full sm:w-auto sm:mt-0">
                        @auth
                            <button onclick="showReservationConfirmation({{ $flight->id }}, '{{ $flight->destination->ville }}', {{ $flight->price }})"
                                class="px-4 py-2 w-full text-sm font-medium text-white bg-blue-600 rounded-lg transition-colors duration-200 sm:w-auto hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <i class="mr-2 fas fa-ticket-alt"></i>
                                Réserver maintenant
                            </button>
                        @else
                            <a href="{{ route('login') }}"
                               class="inline-flex justify-center items-center px-4 py-2 w-full text-sm font-medium text-white bg-gray-600 rounded-lg transition-colors duration-200 sm:w-auto hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                <i class="mr-2 fas fa-sign-in-alt"></i>
                                Se connecter pour réserver
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
@empty
    <div class="p-8 text-center bg-white rounded-lg shadow-lg">
        <div class="flex flex-col justify-center items-center">
            <svg class="mx-auto w-24 h-24 text-gray-400 sm:w-32 sm:h-32" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 10h.01M15 10h.01M9 14h.01M15 14h.01"></path>
            </svg>
            <h3 class="mt-4 text-xl font-bold text-gray-900 sm:text-2xl">Aucun vol disponible</h3>
            <p class="mt-2 text-gray-600">Essayez de modifier vos critères de recherche pour trouver plus de résultats.</p>
            <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})"
                    class="inline-flex items-center px-4 py-2 mt-6 text-sm font-medium text-white bg-blue-600 rounded-lg transition-colors duration-200 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <i class="mr-2 fas fa-search"></i>
                Nouvelle recherche
            </button>
        </div>
    </div>
@endforelse

@if(($flights ?? collect())->hasPages())
    <div class="mt-8">
        {{ $flights->links() }}
    </div>
@endif
