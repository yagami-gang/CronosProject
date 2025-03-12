@extends('site.layouts.app')

@section('content')
<!-- Hero Section avec animation de particules -->
<div class="relative min-h-screen bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-900 overflow-hidden">
    <div class="absolute inset-0" id="particles-js"></div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32">
        <div class="text-center">
            <h1 class="text-5xl md:text-7xl font-extrabold text-white mb-8 animate-fade-in-up">
                Explorez le Monde<br>
                <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-indigo-400">
                    En Toute Liberté
                </span>
            </h1>
            <p class="text-xl md:text-2xl text-blue-100 mb-12 max-w-3xl mx-auto animate-fade-in-up-delay">
                Découvrez des destinations extraordinaires et vivez des expériences inoubliables
            </p>
            
            <!-- Formulaire de recherche rapide -->
            <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-6 max-w-4xl mx-auto mb-12">
                <form class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="relative">
                        <label class="text-white text-sm mb-1 block">Départ</label>
                        <input type="text" placeholder="D'où partez-vous ?" 
                               class="w-full px-4 py-3 rounded-xl bg-white/20 text-white placeholder-blue-100 border border-white/30 focus:border-white focus:ring-2 focus:ring-white/50">
                    </div>
                    <div class="relative">
                        <label class="text-white text-sm mb-1 block">Destination</label>
                        <input type="text" placeholder="Où allez-vous ?" 
                               class="w-full px-4 py-3 rounded-xl bg-white/20 text-white placeholder-blue-100 border border-white/30 focus:border-white focus:ring-2 focus:ring-white/50">
                    </div>
                    <div class="relative">
                        <label class="text-white text-sm mb-1 block">Date</label>
                        <input type="date" 
                               class="w-full px-4 py-3 rounded-xl bg-white/20 text-white border border-white/30 focus:border-white focus:ring-2 focus:ring-white/50">
                    </div>
                    <div class="relative">
                        <label class="text-white text-sm mb-1 block">&nbsp;</label>
                        <button type="submit" 
                                class="w-full px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-500 hover:from-blue-600 hover:to-indigo-600 text-white font-medium rounded-xl transition-all duration-300 transform hover:scale-105">
                            <i class="fas fa-search mr-2"></i>Rechercher
                        </button>
                    </div>
                </form>
            </div>

            <!-- Statistiques -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 max-w-4xl mx-auto">
                <div class="text-center">
                    <div class="text-4xl font-bold text-white mb-2">50+</div>
                    <div class="text-blue-200">Destinations</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-white mb-2">1M+</div>
                    <div class="text-blue-200">Voyageurs</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-white mb-2">24/7</div>
                    <div class="text-blue-200">Support</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-white mb-2">4.9/5</div>
                    <div class="text-blue-200">Satisfaction</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Vague décorative -->
    <div class="absolute bottom-0 left-0 right-0">
        <svg class="w-full h-30 fill-current text-gray-50" viewBox="0 0 1440 74" xmlns="http://www.w3.org/2000/svg">
            <path d="M0,32L60,42.7C120,53,240,75,360,74.7C480,75,600,53,720,42.7C840,32,960,32,1080,37.3C1200,43,1320,53,1380,58.7L1440,64L1440,74L1380,74C1320,74,1200,74,1080,74C960,74,840,74,720,74C600,74,480,74,360,74C240,74,120,74,60,74L0,74Z"></path>
        </svg>
    </div>
</div>

<!-- Services Premium -->
<div class="py-24 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Services Premium</h2>
            <div class="w-24 h-1 bg-gradient-to-r from-blue-500 to-indigo-500 mx-auto"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
            @foreach([
                ['icon' => 'fas fa-concierge-bell', 'title' => 'Service VIP', 'color' => 'blue', 
                 'description' => 'Profitez d\'un service personnalisé et d\'un accès aux salons privés'],
                ['icon' => 'fas fa-bed', 'title' => 'Confort Premium', 'color' => 'indigo',
                 'description' => 'Sièges spacieux et prestations haut de gamme à bord'],
                ['icon' => 'fas fa-glass-cheers', 'title' => 'Expériences Uniques', 'color' => 'purple',
                 'description' => 'Découvrez des services exclusifs et des offres spéciales']
            ] as $service)
            <div class="group">
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-{{ $service['color'] }}-100 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-{{ $service['color'] }}-500 transition-colors duration-300">
                        <i class="{{ $service['icon'] }} text-2xl text-{{ $service['color'] }}-500 group-hover:text-white transition-colors duration-300"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">{{ $service['title'] }}</h3>
                    <p class="text-gray-600">{{ $service['description'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Destinations Populaires avec effet Parallax -->
<div class="relative py-24 bg-fixed bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1436491865332-7a61a109cc05?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80');">
    <div class="absolute inset-0 bg-gradient-to-r from-blue-900/90 to-indigo-900/90"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-white mb-4">Destinations Populaires</h2>
            <div class="w-24 h-1 bg-gradient-to-r from-blue-400 to-indigo-400 mx-auto"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach([
                ['city' => 'Paris', 'image' => 'paris.jpeg', 'price' => '250'],
                ['city' => 'Dubai', 'image' => 'dubai.jpeg', 'price' => '450'],
                ['city' => 'New York', 'image' => 'newyork.jpeg', 'price' => '400']
            ] as $destination)
            <div class="group cursor-pointer">
                <div class="relative overflow-hidden rounded-2xl aspect-[4/3]">
                    <img src="{{ asset('images/destinations/' . $destination['image']) }}" 
                         alt="{{ $destination['city'] }}" 
                         class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-black/50 to-transparent opacity-60 group-hover:opacity-75 transition-opacity duration-300"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-6">
                        <h3 class="text-2xl font-bold text-white mb-2">{{ $destination['city'] }}</h3>
                        <p class="text-white/90">À partir de {{ $destination['price'] }}€</p>
                        <button class="mt-4 px-6 py-2 bg-white/20 backdrop-blur-sm text-white rounded-lg hover:bg-white/30 transition-colors duration-300">
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
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
            <div class="md:flex">
                <div class="md:w-1/2 p-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Restez Informé</h2>
                    <p class="text-gray-600 mb-8">Recevez nos meilleures offres et découvrez nos destinations exclusives</p>
                    <form class="space-y-4">
                        <div>
                            <input type="email" placeholder="Votre adresse email" 
                                   class="w-full px-6 py-4 rounded-xl border-2 border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-300">
                        </div>
                        <button type="submit" 
                                class="w-full px-6 py-4 bg-gradient-to-r from-blue-500 to-indigo-500 text-white font-medium rounded-xl hover:from-blue-600 hover:to-indigo-600 transform hover:scale-105 transition-all duration-300">
                            S'abonner à la Newsletter
                        </button>
                    </form>
                </div>
                <div class="md:w-1/2 relative">
                    <img src="{{ asset('images/newsletter-bg.jpeg') }}" 
                         alt="Newsletter" 
                         class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-500/50 to-indigo-500/50"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Application Mobile avec Animations -->
<div class="py-24 bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="lg:flex lg:items-center lg:justify-between">
            <div class="lg:w-1/2 pr-12">
                <h2 class="text-4xl font-bold text-gray-900 mb-6">
                    Votre Voyage dans<br>
                    <span class="text-blue-600">Votre Poche</span>
                </h2>
                <p class="text-xl text-gray-600 mb-8">
                    Téléchargez notre application mobile et profitez d'une expérience de voyage sans égale
                </p>
                <ul class="space-y-4 mb-12">
                    @foreach([
                        'Réservation instantanée',
                        'Suivi des vols en temps réel',
                        'Carte d\'embarquement digitale',
                        'Programme de fidélité'
                    ] as $feature)
                    <li class="flex items-center text-gray-700">
                        <i class="fas fa-check-circle text-blue-500 mr-3"></i>
                        {{ $feature }}
                    </li>
                    @endforeach
                </ul>
                <div class="flex gap-4">
                    <a href="#" class="transform hover:scale-105 transition-transform duration-300">
                        <img src="{{ asset('images/app-store.svg') }}" alt="App Store" class="h-14">
                    </a>
                    <a href="#" class="transform hover:scale-105 transition-transform duration-300">
                        <img src="{{ asset('images/play-store.svg') }}" alt="Play Store" class="h-14">
                    </a>
                </div>
            </div>
            <div class="lg:w-1/2 mt-12 lg:mt-0">
                <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-100 to-indigo-100 rounded-[3rem] transform rotate-6"></div>
                    <div class="relative transform hover:rotate-6 transition-transform duration-700">
                        <img src="{{ asset('images/app-mockup.svg') }}" 
                             alt="Application Mobile" 
                             class="w-full max-w-md mx-auto drop-shadow-2xl">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bouton Retour en Haut -->
<button id="scrollToTop" 
        class="fixed bottom-8 right-8 bg-blue-600 text-white p-4 rounded-full shadow-lg opacity-0 invisible transform translate-y-8 transition-all duration-300 hover:bg-blue-700 focus:outline-none z-50">
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
