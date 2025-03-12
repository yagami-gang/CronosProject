@extends('site.layouts.app')

@section('content')
<div class="min-h-screen pb-20 pt-20 bg-gradient-to-b from-blue-900 via-blue-800 to-blue-700">
    <!-- Hero Section -->
    <div class="pt-10 pb-20 px-4">
        <div class="max-w-7xl mx-auto text-center">
            <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-4">Trouvez votre vol idéal</h1>
            <p class="text-xl text-blue-100 mb-8">Des milliers de destinations à portée de clic</p>
        </div>
    </div>

    <!-- Search Form Section -->
    <div class="max-w-7xl mx-auto px-4 -mt-10">
        <div class="bg-white rounded-2xl shadow-2xl p-8 mb-12">
            <form action="{{ route('flights.search') }}" method="GET" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="space-y-2">
                        <label for="departure" class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-plane-departure text-blue-600 mr-2"></i>Ville de départ
                        </label>
                        <div class="relative">
                            <input type="text" name="departure" id="departure" value="{{ request('departure') ?? '' }}" 
                                   class="block w-full pl-4 pr-10 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Ex: Douala">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <i class="fas fa-map-marker-alt text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="destination" class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-plane-arrival text-blue-600 mr-2"></i>Destination
                        </label>
                        <div class="relative">
                            <input type="text" name="destination" id="destination" value="{{ request('destination') ?? '' }}"
                                   class="block w-full pl-4 pr-10 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Ex: Yaoundé">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <i class="fas fa-map-marker-alt text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="date" class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-calendar-alt text-blue-600 mr-2"></i>Date du vol
                        </label>
                        <div class="relative">
                            <input type="date" name="date" id="date" value="{{ request('date') ?? '' }}"
                                   class="block w-full pl-4 pr-10 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="price_max" class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-tags text-blue-600 mr-2"></i>Budget maximum
                        </label>
                        <div class="relative">
                            <input type="number" name="price_max" id="price_max" value="{{ request('price_max') ?? '' }}"
                                   class="block w-full pl-4 pr-10 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Ex: 150000">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <span class="text-gray-400">FCFA</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-center pt-4">
                    <button type="submit" class="inline-flex items-center px-8 py-4 bg-blue-600 text-white text-lg font-semibold rounded-xl hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        <i class="fas fa-search mr-2"></i>
                        Rechercher un vol
                    </button>
                </div>
            </form>
        </div>

        <!-- Results Section -->
        <div class="space-y-6 mb-12">
            @forelse ($flights ?? [] as $flight)
                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex flex-col md:flex-row justify-between items-center">
                            <div class="flex-1 flex items-center space-x-8 mb-4 md:mb-0">
                                <div class="flex flex-col items-center">
                                    <span class="text-2xl font-bold text-gray-900">{{ substr($flight->departure ?? '', 0, 3) }}</span>
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
                                    <span class="text-2xl font-bold text-gray-900">{{ substr($flight->destination ?? '', 0, 3) }}</span>
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
        </div>

        <!-- Popular Destinations -->
        <div class="bg-white rounded-xl shadow-lg p-8 mb-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Destinations populaires</h2>
            @if(count($popularDestinations ?? []) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($popularDestinations as $destination)
                        <div class="group relative rounded-xl overflow-hidden cursor-pointer">
                            <img src="{{ asset('images/destinations/' . ($destination->image ?? 'default.jpg')) }}" 
                                 alt="{{ $destination->city ?? 'Destination' }}" 
                                 class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-300">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                            <div class="absolute bottom-0 left-0 right-0 p-4">
                                <h3 class="text-xl font-bold text-white">{{ $destination->city ?? 'Ville inconnue' }}</h3>
                                <p class="text-sm text-gray-200">À partir de {{ number_format($destination->min_price ?? 0, 0, ',', ' ') }} FCFA</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <div class="flex justify-center mb-4">
                        <i class="fas fa-map-marked-alt text-gray-400 text-5xl"></i>
                    </div>
                    <h3 class="text-xl text-gray-600 mb-2">Aucune destination populaire disponible</h3>
                    <p class="text-gray-500">Nos destinations populaires seront bientôt disponibles.</p>
                </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function showReservationConfirmation(flightId, destination, price) {
        Swal.fire({
            title: 'Réservation rapide',
            html: `
                <div class="text-left">
                    <p class="mb-3"><strong>Destination:</strong> ${destination}</p>
                    <p class="mb-3"><strong>Prix:</strong> ${price.toLocaleString('fr-FR')} FCFA</p>
                    <div class="form-group mb-3">
                        <label for="passengers" class="form-label">Nombre de passagers:</label>
                        <select id="passengers" class="form-control">
                            <option value="1">1 passager</option>
                            <option value="2">2 passagers</option>
                            <option value="3">3 passagers</option>
                            <option value="4">4 passagers</option>
                            <option value="5">5 passagers</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="travel_date" class="form-label">Date de voyage:</label>
                        <input type="date" id="travel_date" class="form-control" min="${getTomorrowDate()}">
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Confirmer la réservation',
            cancelButtonText: 'Annuler',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            preConfirm: () => {
                const passengers = document.getElementById('passengers').value;
                const travelDate = document.getElementById('travel_date').value;
                
                if (!travelDate) {
                    Swal.showValidationMessage('Veuillez sélectionner une date de voyage');
                    return false;
                }
                
                return { passengers, travelDate };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Afficher un indicateur de chargement
                Swal.fire({
                    title: 'Traitement en cours...',
                    html: 'Veuillez patienter pendant que nous traitons votre réservation',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                // Envoyer les données au serveur
                fetch('{{ route("reservations.quick-store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        flight_id: flightId,
                        passengers_count: result.value.passengers,
                        travel_date: result.value.travelDate,
                        price_paid: price * result.value.passengers,
                        seat_number: result.value.passengers, // Random seat number between 1-100
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Réservation confirmée!',
                            text: data.message,
                            confirmButtonText: 'Voir mes réservations',
                            showCancelButton: true,
                            cancelButtonText: 'Continuer mes recherches'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '{{ route("reservations.index") }}';
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur',
                            text: data.message || 'Une erreur est survenue lors de la réservation.'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur',
                        text: 'Une erreur est survenue lors de la communication avec le serveur.'
                    });
                });
            }
        });
    }
    function getTomorrowDate() {
        const tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1);
        return tomorrow.toISOString().split('T')[0];
    }
</script>
@endpush
@endsection