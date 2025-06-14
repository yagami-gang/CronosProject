@forelse ($flights ?? [] as $flight)
    <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300">
        <div class="p-6">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="flex-1 flex items-center space-x-8 mb-4 md:mb-0">
                    <div class="flex flex-col items-center">
                        <span class="text-2xl font-bold text-gray-900">{{ $flight->villeDepart->code_aeroport ?? substr($flight->departure ?? '', 0, 3) }}</span>
                        <span class="text-sm text-gray-500">{{ ($flight->departure_time ?? now())->format('H:i') }}</span>
                    </div>

                    <div class="flex-1 relative px-8">
                        <div class="h-0.5 bg-gray-300 absolute w-full top-1/2"></div>
                        <div class="flex justify-center">
                            <span class="bg-white p-1 rounded-full z-10">
                                <i class="fas fa-plane text-blue-600 transform rotate-90"></i>
                            </span>
                        </div>
                        <div class="text-center text-sm text-gray-500 mt-2">
                            {{ $flight->duration ?? 0 }} min
                        </div>
                    </div>

                    <div class="flex flex-col items-center">
                        <span class="text-2xl font-bold text-gray-900">{{ $flight->destination->code_aeroport ?? substr($flight->destination ?? '', 0, 3) }}</span>
                        <span class="text-sm text-gray-500">{{ ($flight->arrival_time ?? now())->format('H:i') }}</span>
                    </div>
                </div>

                <div class="flex flex-col items-end">
                    <div class="text-3xl font-bold text-blue-600">{{ number_format($flight->price ?? 0, 0, ',', ' ') }} <span class="text-sm">FCFA</span></div>
                    <div class="text-sm text-gray-500">par personne</div>
                </div>
            </div>

            <div class="mt-6 flex flex-col sm:flex-row justify-between items-center border-t border-gray-100 pt-4">
                <div class="flex items-center space-x-4 mb-4 sm:mb-0">
                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm">
                        <i class="fas fa-check-circle mr-1"></i>{{ $flight->available_seats ?? 0 }} places disponibles
                    </span>
                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                        <i class="fas fa-couch mr-1"></i>{{ $flight->class ?? 'Standard' }}
                    </span>
                    <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-sm">
                        <i class="fas fa-plane mr-1"></i>Vol {{ $flight->flight_number ?? 'N/A' }}
                    </span>
                </div>
                
                @auth
                    <button onclick="showReservationConfirmation({{ $flight->id }}, '{{ $flight->destination->ville }}', {{ $flight->price }})"
                            class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        <i class="fas fa-ticket-alt mr-2"></i>
                        Réserver maintenant
                    </button>
                @else
                    <a href="{{ route('login') }}" 
                       class="inline-flex items-center px-6 py-3 bg-gray-600 text-white font-medium rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Connectez-vous pour réserver
                    </a>
                @endauth
            </div>
        </div>
    </div>
@empty
    <div class="bg-white rounded-xl shadow-lg p-8 text-center">
        <div class="flex flex-col items-center justify-center">
            <svg class="w-48 h-48 text-gray-400 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 10h.01M15 10h.01M9 14h.01M15 14h.01"></path>
            </svg>
        </div>
        <h3 class="text-2xl font-bold text-gray-900 mb-2">Aucun vol disponible</h3>
        <p class="text-gray-600 mb-6">Essayez de modifier vos critères de recherche pour trouver plus de résultats.</p>
        <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})" 
                class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200">
            <i class="fas fa-search mr-2"></i>
            Nouvelle recherche
        </button>
    </div>
@endforelse

@if(($flights ?? collect())->hasPages())
    <div class="mt-8">
        {{ $flights->links() }}
    </div>
@endif