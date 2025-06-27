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
            <form action="{{ route('flights.search') }}" method="GET" class="space-y-6" id="search-form">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="space-y-2">
                        <label for="departure" class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-plane-departure text-blue-600 mr-2"></i>Ville de départ
                        </label>
                        <div class="relative">
                            <select name="departure" id="departure" 
                                   class="block w-full pl-4 pr-10 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Sélectionnez une ville</option>
                                @foreach(\App\Models\Destination::orderBy('ville')->get() as $destination)
                                    <option value="{{ $destination->id }}" {{ request('departure') == $destination->id ? 'selected' : '' }}>
                                        {{ $destination->ville }}
                                    </option>
                                @endforeach
                            </select>
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
                            <select name="destination" id="destination"
                                   class="block w-full pl-4 pr-10 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Sélectionnez une ville</option>
                                @foreach(\App\Models\Destination::orderBy('ville')->get() as $destination)
                                    <option value="{{ $destination->id }}" {{ request('destination') == $destination->id ? 'selected' : '' }}>
                                        {{ $destination->ville }}
                                    </option>
                                @endforeach
                            </select>
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
                            <input type="number" name="price_max" id="price_max" min="0" value="{{ request('price_max') ?? '' }}"
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
        <div class="space-y-6 mb-12" id="search-results">
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

<!-- Add AJAX Search Script -->
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
            Swal.fire({
                title: 'Traitement en cours...',
                html: 'Veuillez patienter pendant que nous traitons votre réservation',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            fetch('{{ route("payment.initiate") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    flight_id: flightId,
                    passengers_count: result.value.passengers,
                    travel_date: result.value.travelDate,
                    amount: price * result.value.passengers,
                    item_name: `Réservation de vol pour ${result.value.passengers} personne(s)`
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.payment_url) {
                    // Rediriger vers la page de confirmation
                    Monetbil.init({
                            url: data.payment_url
                        });
                    // Afficher un message à l'utilisateur
                    // Swal.fire({
                    //     title: 'Redirection en cours',
                    //     text: 'Vous allez être redirigé vers la page de paiement sécurisée',
                    //     icon: 'info',
                    //     showConfirmButton: true,
                    //     confirmButtonText: 'OK',
                    //     allowOutsideClick: false
                    // }).then(() => {
                    //     // Ouvrir le widget dans un nouvel onglet
                    //     //openMonetbilWidget(data.payment_url);
                    // });
                } else {
                    throw new Error(data.message || 'Erreur lors de l\'initialisation du paiement');
                }
            })
            .catch(error => {
                console.error('Erreur de paiement:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: `Une erreur est survenue lors de l'initialisation du paiement: ${error.message}`,
                    confirmButtonText: 'OK'
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
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('search-form');
        const resultsContainer = document.getElementById('search-results');
        const inputs = ['departure', 'destination', 'date', 'price_max'];
        
        // Add event listeners to all form inputs
        inputs.forEach(inputId => {
            const element = document.getElementById(inputId);
            ['change', 'input'].forEach(evt => {
                element.addEventListener(evt, performSearch);
            });
        });
        
        // Prevent default form submission and use AJAX instead
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            performSearch();
        });
        
        function performSearch() {
            // Check if departure and destination are the same
            const departure = document.getElementById('departure').value;
            const destination = document.getElementById('destination').value;
            
            if (departure && destination && departure === destination) {
                // Afficher l'erreur avec Toastr
                toastr.error("La ville de départ et la ville d'arrivée doivent être différentes", 'Erreur de sélection', {
                    closeButton: true,
                    timeOut: 5000,
                    progressBar: true
                });
                
                // Réinitialiser le champ de destination
                document.getElementById('destination').value = '';
                return;
            }
            
            // Show loading indicator
            resultsContainer.innerHTML = '<div class="flex justify-center py-12"><i class="fas fa-spinner fa-spin fa-3x text-blue-500"></i></div>';
            
            // Get form data
            const formData = new FormData(form);
            const searchParams = new URLSearchParams(formData);
            
            // Fetch results
            fetch(`${form.action}?${searchParams.toString()}&ajax=1`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                resultsContainer.innerHTML = html;
                
                // Update URL with search parameters without reloading the page
                const url = new URL(window.location);
                for (const [key, value] of formData.entries()) {
                    if (value) {
                        url.searchParams.set(key, value);
                    } else {
                        url.searchParams.delete(key);
                    }
                }
                window.history.pushState({}, '', url);
            })
            .catch(error => {
                console.error('Error:', error);
                resultsContainer.innerHTML = '<div class="bg-red-100 p-4 rounded-lg text-red-700">Une erreur est survenue lors de la recherche. Veuillez réessayer.</div>';
            });
        }
    });
</script>
@endpush
@endsection