@extends('site.layouts.app')

@section('content')
<!-- Hero Section avec animation de particules -->
<div class="overflow-hidden relative min-h-screen bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-900">
    <div class="absolute inset-0" id="particles-js"></div>

    <div class="relative px-4 py-32 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="mb-8 text-5xl font-extrabold text-white md:text-7xl animate-fade-in-up">
                Explorez le Monde<br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-400">
                    En Toute Liberté
                </span>
            </h1>
            <p class="mx-auto mb-12 max-w-3xl text-xl text-blue-100 md:text-2xl animate-fade-in-up-delay">
                Découvrez des destinations extraordinaires et vivez des expériences inoubliables
            </p>

            <!-- Formulaire de recherche rapide -->
            <div class="p-6 mx-auto mb-12 max-w-4xl rounded-2xl backdrop-blur-lg bg-white/10">
                <form id="search-form" action="{{ route('flights.search') }}" method="GET" class="grid grid-cols-1 gap-4 md:grid-cols-4">
                    @csrf
                    <div class="relative">
                        <label for="departure" class="block mb-1 text-sm text-white">Départ</label>
                        <select id="departure" name="departure" required
                               class="px-4 py-3 w-full rounded-xl border appearance-none text-Black bg-white/20 border-white/30 focus:border-white focus:ring-2 focus:ring-white/50">
                            <option value="">D'où partez-vous ?</option>
                            @foreach(\App\Models\Destination::orderBy('ville')->get() as $city)
                                <option value="{{ $city->id }}">{{ $city->ville }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="relative">
                        <label for="destination" class="block mb-1 text-sm text-white">Destination</label>
                        <select id="destination" name="destination" required
                               class="px-4 py-3 w-full text-black rounded-xl border appearance-none bg-white/20 border-white/30 focus:border-white focus:ring-2 focus:ring-white/50">
                            <option value="">Où allez-vous ?</option>
                            @foreach(\App\Models\Destination::orderBy('ville')->get() as $city)
                                <option value="{{ $city->id }}">{{ $city->ville }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="relative">
                        <label for="date" class="block mb-1 text-sm text-white">Date</label>
                        <input type="date" id="date" name="date" min="{{ date('Y-m-d') }}"
                               class="px-4 py-3 w-full text-white rounded-xl border bg-white/20 border-white/30 focus:border-white focus:ring-2 focus:ring-white/50">
                    </div>
                    <div class="relative">
                        <label for="price_max" class="block mb-1 text-sm text-white">Prix max</label>
                        <input type="number" id="price_max" name="price_max" placeholder="Prix maximum"
                               class="px-4 py-3 w-full text-white rounded-xl border bg-white/20 border-white/30 focus:border-white focus:ring-2 focus:ring-white/50">
                    </div>
                    <div class="md:col-span-4">
                        <button type="submit"
                                class="px-6 py-3 w-full font-medium text-white bg-gradient-to-r from-blue-500 to-indigo-500 rounded-xl transition-all duration-300 transform hover:from-blue-600 hover:to-indigo-600 hover:scale-105">
                            <i class="mr-2 fas fa-search"></i>Rechercher des vols
                        </button>
                    </div>
                </form>
                <!-- Conteneur pour les résultats de recherche -->
                <div id="search-results" class="mt-8"></div>
            </div>

            @push('scripts')
            <script>
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('search-form');
                const resultsContainer = document.getElementById('search-results');
                const inputs = ['departure', 'destination', 'date', 'price_max'];

                // Add event listeners to all form inputs
                inputs.forEach(inputId => {
                    const element = document.getElementById(inputId);
                    if (element) {
                        ['change', 'input'].forEach(evt => {
                            element.addEventListener(evt, performSearch);
                        });
                    }
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
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'text/html'
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
                        resultsContainer.innerHTML = `
                            <div class="p-4 text-red-700 bg-red-100 rounded-lg">
                                Une erreur est survenue lors de la recherche. Veuillez réessayer.
                            </div>`;
                    });
                }
            });
            </script>
            @endpush

            <!-- Statistiques -->
            <div class="grid grid-cols-2 gap-8 mx-auto max-w-4xl md:grid-cols-4">
                <div class="text-center">
                    <div class="mb-2 text-4xl font-bold text-white">50+</div>
                    <div class="text-blue-200">Destinations</div>
                </div>
                <div class="text-center">
                    <div class="mb-2 text-4xl font-bold text-white">1M+</div>
                    <div class="text-blue-200">Voyageurs</div>
                </div>
                <div class="text-center">
                    <div class="mb-2 text-4xl font-bold text-white">24/7</div>
                    <div class="text-blue-200">Support</div>
                </div>
                <div class="text-center">
                    <div class="mb-2 text-4xl font-bold text-white">4.9/5</div>
                    <div class="text-blue-200">Satisfaction</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Vague décorative -->
    <div class="absolute right-0 bottom-0 left-0">
        <svg class="w-full text-gray-50 fill-current h-30" viewBox="0 0 1440 74" xmlns="http://www.w3.org/2000/svg">
            <path d="M0,32L60,42.7C120,53,240,75,360,74.7C480,75,600,53,720,42.7C840,32,960,32,1080,37.3C1200,43,1320,53,1380,58.7L1440,64L1440,74L1380,74C1320,74,1200,74,1080,74C960,74,840,74,720,74C600,74,480,74,360,74C240,74,120,74,60,74L0,74Z"></path>
        </svg>
    </div>
</div>

<!-- Services Premium -->
<div class="py-24 bg-gray-50">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="mb-16 text-center">
            <h2 class="mb-4 text-4xl font-bold text-gray-900">Services Premium</h2>
            <div class="mx-auto w-24 h-1 bg-gradient-to-r from-blue-500 to-indigo-500"></div>
        </div>

        <div class="grid grid-cols-1 gap-12 md:grid-cols-3">
            @foreach([
                ['icon' => 'fas fa-concierge-bell', 'title' => 'Service VIP', 'color' => 'blue',
                 'description' => 'Profitez d\'un service personnalisé et d\'un accès aux salons privés'],
                ['icon' => 'fas fa-bed', 'title' => 'Confort Premium', 'color' => 'indigo',
                 'description' => 'Sièges spacieux et prestations haut de gamme à bord'],
                ['icon' => 'fas fa-glass-cheers', 'title' => 'Expériences Uniques', 'color' => 'purple',
                 'description' => 'Découvrez des services exclusifs et des offres spéciales']
            ] as $service)
            <div class="group">
                <div class="p-8 bg-white rounded-2xl shadow-lg transition-all duration-300 transform hover:shadow-2xl hover:-translate-y-2">
                    <div class="w-16 h-16 bg-{{ $service['color'] }}-100 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-{{ $service['color'] }}-500 transition-colors duration-300">
                        <i class="{{ $service['icon'] }} text-2xl text-{{ $service['color'] }}-500 group-hover:text-white transition-colors duration-300"></i>
                    </div>
                    <h3 class="mb-4 text-xl font-bold text-gray-900">{{ $service['title'] }}</h3>
                    <p class="text-gray-600">{{ $service['description'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Destinations Populaires avec effet Parallax -->
<div class="relative py-24 bg-fixed bg-center bg-cover" style="background-image: url('https://images.unsplash.com/photo-1436491865332-7a61a109cc05?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80');">
    <div class="absolute inset-0 bg-gradient-to-r from-blue-900/90 to-indigo-900/90"></div>
    <div class="relative px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="mb-16 text-center">
            <h2 class="mb-4 text-4xl font-bold text-white">Destinations Populaires</h2>
            <div class="mx-auto w-24 h-1 bg-gradient-to-r from-blue-400 to-indigo-400"></div>
        </div>

        <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
            @foreach([
                ['city' => 'Paris', 'image' => 'paris.jpeg', 'price' => '250'],
                ['city' => 'Dubai', 'image' => 'dubai.jpeg', 'price' => '450'],
                ['city' => 'New York', 'image' => 'newyork.jpeg', 'price' => '400']
            ] as $destination)
            <div class="cursor-pointer group">
                <div class="relative overflow-hidden rounded-2xl aspect-[4/3]">
                    <img src="{{ asset('images/destinations/' . $destination['image']) }}"
                         alt="{{ $destination['city'] }}"
                         class="object-cover w-full h-full transition-transform duration-700 transform group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t to-transparent opacity-60 transition-opacity duration-300 from-black/75 via-black/50 group-hover:opacity-75"></div>
                    <div class="absolute right-0 bottom-0 left-0 p-6">
                        <h3 class="mb-2 text-2xl font-bold text-white">{{ $destination['city'] }}</h3>
                        <p class="text-white/90">À partir de {{ $destination['price'] }}€</p>
                        <button class="px-6 py-2 mt-4 text-white rounded-lg backdrop-blur-sm transition-colors duration-300 bg-white/20 hover:bg-white/30">
                            Explorer
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Newsletter avec Design Moderne -->
<div class="py-24 bg-gradient-to-br from-blue-50 to-indigo-50">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white rounded-3xl shadow-xl">
            <div class="md:flex">
                <div class="p-12 md:w-1/2">
                    <h2 class="mb-4 text-3xl font-bold text-gray-900">Restez Informé</h2>
                    <p class="mb-8 text-gray-600">Recevez nos meilleures offres et découvrez nos destinations exclusives</p>
                    <form class="space-y-4">
                        <div>
                            <input type="email" placeholder="Votre adresse email"
                                   class="px-6 py-4 w-full rounded-xl border-2 border-gray-200 transition-all duration-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                        </div>
                        <button type="submit"
                                class="px-6 py-4 w-full font-medium text-white bg-gradient-to-r from-blue-500 to-indigo-500 rounded-xl transition-all duration-300 transform hover:from-blue-600 hover:to-indigo-600 hover:scale-105">
                            S'abonner à la Newsletter
                        </button>
                    </form>
                </div>
                <div class="relative md:w-1/2">
                    <img src="{{ asset('images/newsletter-bg.jpeg') }}"
                         alt="Newsletter"
                         class="object-cover w-full h-full">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-500/50 to-indigo-500/50"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Application Mobile avec Animations -->
<div class="overflow-hidden py-24 bg-white">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="lg:flex lg:items-center lg:justify-between">
            <div class="pr-12 lg:w-1/2">
                <h2 class="mb-6 text-4xl font-bold text-gray-900">
                    Votre Voyage dans<br>
                    <span class="text-blue-600">Votre Poche</span>
                </h2>
                <p class="mb-8 text-xl text-gray-600">
                    Téléchargez notre application mobile et profitez d'une expérience de voyage sans égale
                </p>
                <ul class="mb-12 space-y-4">
                    @foreach([
                        'Réservation instantanée',
                        'Suivi des vols en temps réel',
                        'Carte d\'embarquement digitale',
                        'Programme de fidélité'
                    ] as $feature)
                    <li class="flex items-center text-gray-700">
                        <i class="mr-3 text-blue-500 fas fa-check-circle"></i>
                        {{ $feature }}
                    </li>
                    @endforeach
                </ul>
                <div class="flex gap-4">
                    <a href="#" class="transition-transform duration-300 transform hover:scale-105">
                        <img src="{{ asset('images/app-store.svg') }}" alt="App Store" class="h-14">
                    </a>
                    <a href="#" class="transition-transform duration-300 transform hover:scale-105">
                        <img src="{{ asset('images/play-store.svg') }}" alt="Play Store" class="h-14">
                    </a>
                </div>
            </div>
            <div class="mt-12 lg:w-1/2 lg:mt-0">
                <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-100 to-indigo-100 rounded-[3rem] transform rotate-6"></div>
                    <div class="relative transition-transform duration-700 transform hover:rotate-6">
                        <img src="{{ asset('images/app-mockup.svg') }}"
                             alt="Application Mobile"
                             class="mx-auto w-full max-w-md drop-shadow-2xl">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bouton Retour en Haut -->
<button id="scrollToTop"
        class="fixed bottom-3 right-16 z-50 p-4 text-white bg-blue-600 rounded-full shadow-lg opacity-100 transition-all duration-300 transform translate-y-0 hover:bg-blue-700 focus:outline-none">
    <i class="fas fa-arrow-up"></i>
</button>
@push('scripts')
    <script>
        // Gestion du bouton retour en haut
        const scrollToTopButton = document.getElementById('scrollToTop');

        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 500) {
                scrollToTopButton.classList.remove('opacity-0', 'invisible', 'translate-y-8');
                scrollToTopButton.classList.add('opacity-100', 'visible', 'translate-y-0');
            } else {
                scrollToTopButton.classList.add('opacity-0', 'invisible', 'translate-y-8');
                scrollToTopButton.classList.remove('opacity-100', 'visible', 'translate-y-0');
            }
        });

        scrollToTopButton.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    </script>
@endpush

@endsection
