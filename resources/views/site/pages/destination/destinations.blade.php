@extends('site.layouts.app')

@section('content')
<div class="relative bg-gradient-to-b from-blue-900 to-blue-800 py-20">
    <div id="particles-js" class="absolute inset-0"></div>
    <div class="relative container mx-auto px-4">
        <h1 class="text-4xl md:text-5xl font-bold text-center text-white mb-4">Découvrez nos destinations</h1>
        <p class="text-xl text-center text-blue-100 mb-12">Des voyages inoubliables vers les plus belles destinations du monde</p>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Destination Card -->
            <div class="bg-white rounded-xl shadow-2xl overflow-hidden transform transition-all duration-300 hover:scale-105 hover:shadow-3xl">
                <div class="relative">
                    <img src="{{asset('images/destinations/paris.jpeg')}}" 
                         alt="Paris" 
                         class="w-full h-64 object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    <div class="absolute bottom-4 left-4">
                        <h2 class="text-2xl font-bold text-white">Paris</h2>
                        <p class="text-blue-100">France</p>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-calendar-alt text-blue-600 mr-2"></i>
                        <p class="text-gray-600">Départ le 15 Mars 2025</p>
                    </div>
                    <div class="flex items-center mb-4">
                        <i class="fas fa-clock text-blue-600 mr-2"></i>
                        <p class="text-gray-600">7 jours / 6 nuits</p>
                    </div>
                    <p class="text-gray-700 mb-6">Découvrez la Ville Lumière, son art, sa gastronomie et son architecture emblématique.</p>
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <p class="text-sm text-gray-500">À partir de</p>
                            <p class="text-2xl font-bold text-blue-600">899€</p>
                        </div>
                        <div class="flex items-center">
                            <div class="flex text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <span class="ml-2 text-gray-600">4.5/5</span>
                        </div>
                    </div>
                    @guest
                        <a href="{{ route('login') }}" 
                           class="block w-full text-center bg-gradient-to-r from-blue-600 to-blue-800 text-white px-6 py-3 rounded-lg font-semibold hover:from-blue-700 hover:to-blue-900 transform transition-all duration-300 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                            <i class="fas fa-lock mr-2"></i>Connectez-vous pour réserver
                        </a>
                    @else
                        <a href="{{ route('reservations.create', 2) }}" 
                           class="block w-full text-center bg-gradient-to-r from-blue-600 to-blue-800 text-white px-6 py-3 rounded-lg font-semibold hover:from-blue-700 hover:to-blue-900 transform transition-all duration-300 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                            <i class="fas fa-plane-departure mr-2"></i>Réserver maintenant
                        </a>
                    @endguest
                </div>
            </div>
            @forelse ($flights as $flight)
                <div class="bg-white rounded-xl shadow-2xl overflow-hidden transform transition-all duration-300 hover:scale-105 hover:shadow-3xl">
                    <div class="relative">
                        <img src="{{ $flight->destination->image_url ? asset('storage/destinations/' . $flight->destination->image_url) : asset('images/destinations/paris.jpeg') }}"
                            alt="{{ $flight->destination->ville }}" 
                            class="w-full h-64 object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute bottom-4 left-4">
                            <h2 class="text-2xl font-bold text-white">{{ $flight->destination->ville }}</h2>
                            <p class="text-blue-100">{{ $flight->destination->pays }}</p>
                        </div>
                        @if($flight->promotion)
                            <div class="absolute top-4 right-4 bg-red-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                -{{ $flight->promotion }}%
                            </div>
                        @endif
                    </div>
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <i class="fas fa-calendar-alt text-blue-600 mr-2"></i>
                            <p class="text-gray-600">
                                @if($flight->date_depart)
                                    Prochain départ le {{ \Carbon\Carbon::parse($flight->date_depart)->format('d M Y') }}
                                @elseif($flight->next_departure)
                                    Prochain départ le {{ \Carbon\Carbon::parse($flight->next_departure)->format('d M Y') }}
                                @else
                                    Dates flexibles
                                @endif
                            </p>
                        </div>
                        <div class="flex items-center mb-4">
                            <i class="fas fa-clock text-blue-600 mr-2"></i>
                            <p class="text-gray-600">
                                @if($flight->duree_sejour)
                                    {{ $flight->duree_sejour }}
                                @else
                                    {{ $flight->duration_days }} jours / {{ $flight->duration_days - 1 }} nuits
                                @endif
                            </p>
                        </div>
                        <p class="text-gray-700 mb-6">{{ Str::limit($flight->description, 100) }}</p>
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <p class="text-sm text-gray-500">À partir de</p>
                                @if($flight->promotion)
                                    <p class="text-lg line-through text-gray-400">{{ number_format($flight->price, 0, ',', ' ') }}€</p>
                                    <p class="text-2xl font-bold text-blue-600">
                                        {{ number_format($flight->price * (1 - $flight->promotion/100), 0, ',', ' ') }}€
                                    </p>
                                @elseif($flight->prix_a_partir_de)
                                    <p class="text-2xl font-bold text-blue-600">{{ number_format($flight->prix_a_partir_de, 0, ',', ' ') }}€</p>
                                @else
                                    <p class="text-2xl font-bold text-blue-600">{{ number_format($flight->price, 0, ',', ' ') }}€</p>
                                @endif
                            </div>
                            <div class="flex items-center">
                                <div class="flex text-yellow-400">
                                    @if($flight->note)
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $flight->note)
                                                <i class="fas fa-star"></i>
                                            @elseif($i - 0.5 <= $flight->note)
                                                <i class="fas fa-star-half-alt"></i>
                                            @else
                                                <i class="far fa-star"></i>
                                            @endif
                                        @endfor
                                        <span class="ml-2 text-gray-600">{{ number_format($flight->note, 1) }}/5</span>
                                    @else
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $flight->rating)
                                                <i class="fas fa-star"></i>
                                            @elseif($i - 0.5 <= $flight->rating)
                                                <i class="fas fa-star-half-alt"></i>
                                            @else
                                                <i class="far fa-star"></i>
                                            @endif
                                        @endfor
                                        <span class="ml-2 text-gray-600">{{ number_format($flight->rating, 1) }}/5</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @guest
                            <a href="{{ route('login') }}" 
                            class="block w-full text-center bg-gradient-to-r from-blue-600 to-blue-800 text-white px-6 py-3 rounded-lg font-semibold hover:from-blue-700 hover:to-blue-900 transform transition-all duration-300 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                                <i class="fas fa-lock mr-2"></i>Connectez-vous pour réserver
                            </a>
                        @else
                            <button type="button" 
                                   onclick="showReservationConfirmation({{ $flight->id }}, '{{ $flight->destination->ville }}', {{ $flight->price }})"
                                   class="block w-full text-center bg-gradient-to-r from-blue-600 to-blue-800 text-white px-6 py-3 rounded-lg font-semibold hover:from-blue-700 hover:to-blue-900 transform transition-all duration-300 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                                <i class="fas fa-plane-departure mr-2"></i>Réserver maintenant
                            </button>
                        @endguest
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <i class="fas fa-search text-gray-400 text-5xl mb-4"></i>
                    <p class="text-gray-500 text-xl">Aucun vol n'est disponible pour le moment.</p>
                </div>
            @endforelse

            <!-- Répétez le même modèle pour d'autres destinations -->
        </div>
    </div>
</div>

<!-- Section des destinations populaires -->
<div class="bg-gray-50 py-16">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12">Destinations populaires</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="relative rounded-xl overflow-hidden group cursor-pointer">
                <img src="{{asset('images/destinations/rome.jpeg')}}" 
                     class="w-full h-48 object-cover transition-transform duration-300 group-hover:scale-110">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                <div class="absolute bottom-4 left-4">
                    <h3 class="text-white font-semibold">Rome</h3>
                    <p class="text-blue-100 text-sm">Italie</p>
                </div>
            </div>
            <!-- Ajoutez d'autres destinations populaires -->
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.shadow-3xl {
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function showReservationConfirmation(flightId, destination, price) {
        Swal.fire({
            title: '<h2 class="text-2xl font-bold mb-4">Réservation Express</h2>',
            html: `
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="flex items-center mb-6 bg-blue-50 p-4 rounded-lg">
                        <i class="fas fa-plane-departure text-blue-600 text-2xl mr-4"></i>
                        <div>
                            <h3 class="font-semibold text-lg text-gray-800">${destination}</h3>
                            <p class="text-blue-600 font-bold text-xl">${price.toLocaleString('fr-FR')} €</p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="form-group">
                            <label for="passengers" class="block text-gray-700 font-medium mb-2">
                                <i class="fas fa-users text-blue-500 mr-2"></i>Nombre de passagers
                            </label>
                            <select id="passengers" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                ${[1,2,3,4,5].map(num => `
                                    <option value="${num}">${num} passager${num > 1 ? 's' : ''}</option>
                                `).join('')}
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="travel_date" class="block text-gray-700 font-medium mb-2">
                                <i class="fas fa-calendar-alt text-blue-500 mr-2"></i>Date de voyage
                            </label>
                            <input type="date" 
                                   id="travel_date" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                   min="${getTomorrowDate()}">
                        </div>
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: '<i class="fas fa-check mr-2"></i>Confirmer la réservation',
            cancelButtonText: '<i class="fas fa-times mr-2"></i>Annuler',
            confirmButtonColor: '#2563eb',
            cancelButtonColor: '#dc2626',
            customClass: {
                confirmButton: 'px-6 py-3 rounded-lg text-sm font-semibold transition-all duration-200 hover:bg-blue-700',
                cancelButton: 'px-6 py-3 rounded-lg text-sm font-semibold transition-all duration-200 hover:bg-red-700'
            },
            preConfirm: () => {
                const passengers = document.getElementById('passengers').value;
                const travelDate = document.getElementById('travel_date').value;
                
                if (!travelDate) {
                    Swal.showValidationMessage(`
                        <i class="fas fa-exclamation-circle text-red-500 mr-2"></i>
                        Veuillez sélectionner une date de voyage
                    `);
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
