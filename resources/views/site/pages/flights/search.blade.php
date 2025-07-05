@extends('site.layouts.app')

@section('content')
<div class="pt-20 pb-20 min-h-screen bg-gradient-to-b from-blue-900 via-blue-800 to-blue-700">
    <!-- Hero Section -->
    <div class="px-4 pt-10 pb-20">
        <div class="mx-auto max-w-7xl text-center">
            <h1 class="mb-4 text-4xl font-extrabold text-white md:text-5xl">Trouvez votre vol idéal</h1>
            <p class="mb-8 text-xl text-blue-100">Des milliers de destinations à portée de clic</p>
        </div>
    </div>

    <!-- Search Form Section -->
    <div class="px-4 mx-auto -mt-10 max-w-7xl">
        <div class="p-8 mb-12 bg-white rounded-2xl shadow-2xl">
            <form action="{{ route('flights.search') }}" method="GET" class="space-y-6" id="search-form">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
                    <div class="space-y-2">
                        <label for="departure" class="block text-sm font-semibold text-gray-700">
                            <i class="mr-2 text-blue-600 fas fa-plane-departure"></i>Ville de départ
                        </label>
                        <div class="relative">
                            <select name="departure" id="departure"
                                   class="block py-3 pr-10 pl-4 w-full rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Sélectionnez une ville</option>
                                @foreach(\App\Models\Destination::orderBy('ville')->get() as $destination)
                                    <option value="{{ $destination->id }}" {{ request('departure') == $destination->id ? 'selected' : '' }}>
                                        {{ $destination->ville }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="flex absolute inset-y-0 right-0 items-center pr-3 pointer-events-none">
                                <i class="text-gray-400 fas fa-map-marker-alt"></i>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="destination" class="block text-sm font-semibold text-gray-700">
                            <i class="mr-2 text-blue-600 fas fa-plane-arrival"></i>Destination
                        </label>
                        <div class="relative">
                            <select name="destination" id="destination"
                                   class="block py-3 pr-10 pl-4 w-full rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Sélectionnez une ville</option>
                                @foreach(\App\Models\Destination::orderBy('ville')->get() as $destination)
                                    <option value="{{ $destination->id }}" {{ request('destination') == $destination->id ? 'selected' : '' }}>
                                        {{ $destination->ville }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="flex absolute inset-y-0 right-0 items-center pr-3 pointer-events-none">
                                <i class="text-gray-400 fas fa-map-marker-alt"></i>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="date" class="block text-sm font-semibold text-gray-700">
                            <i class="mr-2 text-blue-600 fas fa-calendar-alt"></i>Date du vol
                        </label>
                        <div class="relative">
                            <input type="date" name="date" id="date" value="{{ request('date') ?? '' }}"
                                   class="block py-3 pr-10 pl-4 w-full rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="price_max" class="block text-sm font-semibold text-gray-700">
                            <i class="mr-2 text-blue-600 fas fa-tags"></i>Budget maximum
                        </label>
                        <div class="relative">
                            <input type="number" name="price_max" id="price_max" min="0" value="{{ request('price_max') ?? '' }}"
                                   class="block py-3 pr-10 pl-4 w-full rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Ex: 150000">
                            <div class="flex absolute inset-y-0 right-0 items-center pr-3 pointer-events-none">
                                <span class="text-gray-400">FCFA</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-center pt-4">
                    <button type="submit" class="inline-flex items-center px-8 py-4 text-lg font-semibold text-white bg-blue-600 rounded-xl transition-colors duration-200 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="mr-2 fas fa-search"></i>
                        Rechercher un vol
                    </button>
                </div>
            </form>
        </div>

        <!-- Results Section -->
        <div class="mb-12 space-y-6" id="search-results">
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
        </div>

        <!-- Popular Destinations -->
        <div class="p-8 mb-12 bg-white rounded-xl shadow-lg">
            <h2 class="mb-6 text-2xl font-bold text-gray-900">Destinations populaires</h2>
            @if(count($popularDestinations ?? []) > 0)
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
                    @foreach($popularDestinations as $destination)
                        <div class="overflow-hidden relative rounded-xl cursor-pointer group">
                            <img src="{{ asset('images/destinations/' . ($destination->image ?? 'default.jpg')) }}"
                                 alt="{{ $destination->city ?? 'Destination' }}"
                                 class="object-cover w-full h-48 transition-transform duration-300 group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t to-transparent from-black/70"></div>
                            <div class="absolute right-0 bottom-0 left-0 p-4">
                                <h3 class="text-xl font-bold text-white">{{ $destination->city ?? 'Ville inconnue' }}</h3>
                                <p class="text-sm text-gray-200">À partir de {{ number_format($destination->min_price ?? 0, 0, ',', ' ') }} FCFA</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="py-8 text-center">
                    <div class="flex justify-center mb-4">
                        <i class="text-5xl text-gray-400 fas fa-map-marked-alt"></i>
                    </div>
                    <h3 class="mb-2 text-xl text-gray-600">Aucune destination populaire disponible</h3>
                    <p class="text-gray-500">Nos destinations populaires seront bientôt disponibles.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Add AJAX Search Script -->
@push('scripts')
<script src="https://api.monetbil.cm/widget/v2/js/monetbil.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function showReservationConfirmation(flightId, destination, price) {
    Swal.fire({
        title: '<h2 class="mb-4 text-2xl font-bold">Réservation Express</h2>',
        html: `
            <div class="p-6 bg-white rounded-lg shadow-md">
                <div class="flex items-center p-4 mb-6 bg-blue-50 rounded-lg">
                    <i class="mr-4 text-2xl text-blue-600 fas fa-plane-departure"></i>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">${destination}</h3>
                        <p class="text-xl font-bold text-blue-600">${price.toLocaleString('fr-FR')} €</p>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="form-group">
                        <label for="passengers" class="block mb-2 font-medium text-gray-700">
                            <i class="mr-2 text-blue-500 fas fa-users"></i>Nombre de passagers
                        </label>
                        <select id="passengers" class="px-4 py-2 w-full rounded-lg border border-gray-300 transition-all duration-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            ${[1,2,3,4,5].map(num => `
                                <option value="${num}">${num} passager${num > 1 ? 's' : ''}</option>
                            `).join('')}
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="travel_date" class="block mb-2 font-medium text-gray-700">
                            <i class="mr-2 text-blue-500 fas fa-calendar-alt"></i>Date de voyage
                        </label>
                        <input type="date"
                            id="travel_date"
                            class="px-4 py-2 w-full rounded-lg border border-gray-300 transition-all duration-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            min="${getTomorrowDate()}">
                    </div>
                </div>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: '<i class="mr-2 fas fa-check"></i>Confirmer la réservation',
        cancelButtonText: '<i class="mr-2 fas fa-times"></i>Annuler',
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
                    <i class="mr-2 text-red-500 fas fa-exclamation-circle"></i>
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
                    item_name: `Réservation vol ${destination} pour ${result.value.passengers} passager(s)`
                })
            })
            .then(response => response.json())
            .then(data => {
                Swal.close(); // On ferme la popup "Traitement en cours"

                if (data.success && data.payment_data) {
                    // C'EST LA CORRECTION MAGIQUE !
                    // On appelle le widget Monetbil avec les données reçues du serveur.
                    const monetbilData = data.payment_data;

                    // Ajout des callbacks pour gérer la suite
                    monetbilData.onclose = function() {
                        // L'utilisateur a fermé le widget sans payer
                        console.log('Widget fermé par l\'utilisateur.');
                        Swal.fire('Annulé', 'Le processus de paiement a été annulé.', 'info');
                    };

                    // On lance le widget
                    Monetbil.pay(monetbilData);

                } else {
                    throw new Error(data.message || 'Erreur lors de l\'initialisation du paiement');
                }
            })
            .catch(error => {
                console.error('Erreur de paiement:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: `Une erreur est survenue : ${error.message}`,
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
            resultsContainer.innerHTML = '<div class="flex justify-center py-12"><i class="text-blue-500 fas fa-spinner fa-spin fa-3x"></i></div>';

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
                resultsContainer.innerHTML = '<div class="p-4 text-red-700 bg-red-100 rounded-lg">Une erreur est survenue lors de la recherche. Veuillez réessayer.</div>';
            });
        }
    });
</script>
@endpush
@endsection
