<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - Votre Partenaire de Voyage</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><path fill='%234338ca' d='M50 0a50 50 0 1 0 0 100A50 50 0 0 0 50 0zm0 20a30 30 0 1 1 0 60 30 30 0 0 1 0-60z'/></svg>">
    
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <!-- Particles.js -->
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <!-- Tailwind CSS -->
    @stack('styles')
</head>
<body class="font-sans antialiased">
    <!-- Header -->
    <header class="fixed w-full z-50 transition-all duration-300 bg-blue-900/95 backdrop-blur-sm shadow-lg" id="main-header">
        <nav class="bg-transparent">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20">
                    <div class="flex items-center">
                        <!-- Logo SVG -->
                        <a href="{{ route('home') }}" class="flex-shrink-0">
                            <img src="{{ asset('images/logo.svg') }}" alt="Logo" class="h-12 w-auto brightness-150 drop-shadow-[0_0_15px_rgba(255,255,255,0.3)] transition-all duration-300 hover:brightness-125">
                        </a>
                    </div>
                    
                    <div class="hidden md:flex items-center space-x-8">
                        <a href="{{ route('flights.search') }}" class="text-white hover:text-blue-200 transition-colors">Vols</a>
                        <a href="{{ route('public.destinations') }}" class="text-white hover:text-blue-200 transition-colors">Destinations</a>
                        <a href="#services" class="text-white hover:text-blue-200 transition-colors">Services</a>
                        @auth
                            <div class="relative group">
                                <button class="flex items-center space-x-2 text-white focus:outline-none">
                                    <img src="{{ Auth::user()->avatar ?? asset('images/default-avatar.png') }}" 
                                         class="w-8 h-8 rounded-full object-cover">
                                    <span>{{ Auth::user()->name }}</span>
                                </button>
                                <div class="absolute right-0 w-48 mt-2 py-2 bg-white rounded-xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300">
                                    <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">
                                        <i class="fas fa-user mr-2"></i>Mon profil
                                    </a>
                                    <a href="{{ route('reservations.index') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">
                                        <i class="fas fa-ticket-alt mr-2"></i>Mes réservations
                                    </a>
                                    <hr class="my-2">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-2 text-gray-800 hover:bg-gray-100">
                                            <i class="fas fa-sign-out-alt mr-2"></i>Déconnexion
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="text-white hover:text-blue-200 transition-colors">Connexion</a>
                            <a href="{{ route('register') }}" 
                               class="bg-white text-blue-600 px-4 py-2 rounded-lg hover:bg-blue-50 transition-colors">
                                Inscription
                            </a>
                        @endauth
                    </div>

                    <!-- Mobile menu button -->
                    <div class="md:hidden flex items-center">
                        <button class="mobile-menu-button text-white focus:outline-none">
                            <i class="fas fa-bars text-2xl"></i>
                        </button>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Mobile menu -->
    <div class="mobile-menu hidden md:hidden fixed inset-0 z-40 bg-blue-900/95 backdrop-blur-sm">
        <div class="p-4">
            <div class="flex justify-end">
                <button class="mobile-menu-close text-white focus:outline-none">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>
            <div class="flex flex-col space-y-4 mt-8">
                <a href="{{ route('flights.search') }}" class="text-white text-lg">Vols</a>
                <a href="{{ route('public.destinations') }}" class="text-white text-lg">Destinations</a>
                <a href="#services" class="text-white text-lg">Services</a>
                @auth
                    <hr class="border-white/20">
                    <a href="{{ route('profile.show') }}" class="text-white text-lg">Mon profil</a>
                    <a href="{{ route('reservations.index') }}" class="text-white text-lg">Mes réservations</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-white text-lg">Déconnexion</button>
                    </form>
                @else
                    <hr class="border-white/20">
                    <a href="{{ route('login') }}" class="text-white text-lg">Connexion</a>
                    <a href="{{ route('register') }}" class="text-white text-lg">Inscription</a>
                @endauth
            </div>
        </div>
    </div>

    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <img src="{{ asset('images/logo.svg') }}" alt="Logo" class="h-12 w-auto brightness-150 drop-shadow-[0_0_15px_rgba(255,255,255,0.3)] transition-all duration-300 hover:brightness-125">
                    <p class="text-gray-400">Votre partenaire de confiance pour des voyages inoubliables</p>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4">Liens rapides</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('flights.search') }}" class="text-gray-400 hover:text-white transition-colors">Rechercher un vol</a></li>
                        <li><a href="{{ route('public.destinations') }}" class="text-gray-400 hover:text-white transition-colors">Destinations</a></li>
                        <li><a href="#services" class="text-gray-400 hover:text-white transition-colors">Nos services</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4">Contact</h3>
                    <ul class="space-y-2">
                        <li class="flex items-center text-gray-400">
                            <i class="fas fa-phone mr-2"></i>
                            +237 6 51 69 98 51
                        </li>
                        <li class="flex items-center text-gray-400">
                            <i class="fas fa-envelope mr-2"></i>
                            contact@cronos.com
                        </li>
                        <li class="flex items-center text-gray-400">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            Yaoudé, Cameroun
                        </li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4">Suivez-nous</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-facebook text-2xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-twitter text-2xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-instagram text-2xl"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <hr class="border-gray-800 my-8">
            
            <div class="flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400">&copy; {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.</p>
                <div class="flex space-x-4 mt-4 md:mt-0">
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">Mentions légales</a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">Politique de confidentialité</a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">CGV</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="{{ asset('js/bootstrap.esm.min.js') }}"></script>
    <script src="{{ asset('js/axios.min.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="{{ asset('js/app.js') }}" type="module"></script>
    <script>

        // Mobile menu
        document.querySelector('.mobile-menu-button').addEventListener('click', function() {
            document.querySelector('.mobile-menu').classList.remove('hidden');
        });

        document.querySelector('.mobile-menu-close').addEventListener('click', function() {
            document.querySelector('.mobile-menu').classList.add('hidden');
        });

        // Particles.js configuration
        if (document.getElementById('particles-js')) {
            particlesJS('particles-js', {
                particles: {
                    number: { value: 80 },
                    color: { value: '#ffffff' },
                    opacity: { value: 0.5 },
                    size: { value: 3 },
                    line_linked: {
                        enable: true,
                        distance: 150,
                        color: '#ffffff',
                        opacity: 0.4,
                        width: 1
                    },
                    move: {
                        enable: true,
                        speed: 2
                    }
                }
            });
        }
    </script>
    @stack('scripts')
</body>
</html>