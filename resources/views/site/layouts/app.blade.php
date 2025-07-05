<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - Votre Partenaire de Voyage</title>

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><path fill='%234338ca' d='M50 0a50 50 0 1 0 0 100A50 50 0 0 0 50 0zm0 20a30 30 0 1 1 0 60 30 30 0 0 1 0-60z'/></svg>">

    <!-- Styles -->
        <script src="https://cdn.tailwindcss.com"></script>
        {{-- @else
            <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        @endif --}}

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

    <!-- Tailwind CSS -->
    @stack('styles')
    <style>
        /* Chat Widget Styles */
        #chat-toggle {
            transition: transform 0.3s ease;
        }

        #chat-toggle.rotate-90 {
            transform: rotate(90deg);
        }

        #chat-window {
            transition: all 0.3s ease;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        #chat-messages {
            scrollbar-width: thin;
            scrollbar-color: rgba(156, 163, 175, 0.5) transparent;
        }

        #chat-messages::-webkit-scrollbar {
            width: 6px;
        }

        #chat-messages::-webkit-scrollbar-track {
            background: transparent;
        }

        #chat-messages::-webkit-scrollbar-thumb {
            background-color: rgba(156, 163, 175, 0.5);
            border-radius: 3px;
        }

        .chat-message {
            margin-bottom: 1rem;
        }

        .chat-message.user {
            text-align: right;
        }

        .typing-indicator {
            display: inline-block;
        }

    </style>
</head>
<body class="font-sans antialiased">
    <!-- Header -->
    <header class="fixed z-50 w-full shadow-lg backdrop-blur-sm transition-all duration-300 bg-blue-900/95" id="main-header">
        <nav class="bg-transparent">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="flex justify-between items-center px-4 h-20">
                    <!-- Logo -->
                    <div class="flex items-center">
                        <a href="{{ route('home') }}" class="flex-shrink-0 transition-transform duration-300 transform hover:scale-105">
                            <img src="{{ asset('images/logo.svg') }}" alt="Logo" class="h-12 w-auto brightness-150 drop-shadow-[0_0_15px_rgba(255,255,255,0.3)] hover:drop-shadow-[0_0_20px_rgba(255,255,255,0.5)] transition-all duration-300">
                        </a>
                    </div>

                    <!-- Navigation Desktop -->
                    <div class="hidden items-center space-x-1 md:flex">

                        <a href="{{ route('home') }}" class="flex items-center px-4 py-2 text-white rounded-lg transition-all duration-300 hover:bg-white/10 group">
                            <i class="mr-2 text-blue-300 fas fa-home group-hover:text-white"></i>
                            <span class="font-medium">Accueil</span>
                        </a>

                        <a href="{{ route('flights.search') }}" class="flex items-center px-4 py-2 text-white rounded-lg transition-all duration-300 hover:bg-white/10 group">
                            <i class="mr-2 text-blue-300 fas fa-plane-departure group-hover:text-white"></i>
                            <span class="font-medium">Vols</span>
                        </a>


                        <a href="#" class="flex items-center px-4 py-2 text-white rounded-lg transition-all duration-300 hover:bg-white/10 group">
                            <i class="mr-2 text-blue-300 fas fa-map-marked-alt group-hover:text-white"></i>
                            <span class="font-medium">Destinations populaires</span>
                        </a>
                        <a href="#services" class="flex items-center px-4 py-2 text-white rounded-lg transition-all duration-300 hover:bg-white/10 group">
                            <i class="mr-2 text-blue-300 fas fa-concierge-bell group-hover:text-white"></i>
                            <span class="font-medium">Services</span>
                        </a>
                        @auth
                            @if (Auth::user()->hasRole('gestionnaire'))
                                <a href="{{ route('manager.dashboard') }}" class="flex items-center px-4 py-2 text-white rounded-lg transition-all duration-300 hover:bg-white/10 group">
                                    <i class="mr-2 text-blue-300 fas fa-lock group-hover:text-white"></i>
                                    <span class="font-medium">Back Office</span>
                                </a>
                            @endif
                        @endauth




                        @auth
                            <div class="relative ml-2 group">
                                <button class="flex items-center px-4 py-2 space-x-2 text-white rounded-lg transition-all duration-300 hover:bg-white/10">
                                    <div class="relative">
                                        <img src="{{ Auth::user()->avatar ?? asset('images/default-avatar.png') }}"
                                             class="object-cover w-9 h-9 rounded-full border-2 transition-colors duration-300 border-white/20 hover:border-blue-300">
                                        <span class="absolute right-0 bottom-0 w-3 h-3 bg-green-400 rounded-full border-2 border-blue-900"></span>
                                    </div>
                                    <span class="font-medium">{{ Auth::user()->name }}</span>
                                    <i class="text-xs opacity-70 transition-transform duration-300 transform fas fa-chevron-down group-hover:opacity-100"></i>
                                </button>

                                <div class="absolute right-0 invisible py-2 mt-2 w-56 rounded-xl border shadow-xl opacity-0 backdrop-blur-sm transition-all duration-300 transform origin-top-right scale-95 bg-white/95 group-hover:opacity-100 group-hover:visible group-hover:scale-100 border-white/10">
                                    <div class="px-4 py-3 border-b border-gray-100/10">
                                        <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                                        <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                                    </div>
                                    <a href="{{ route('profile.show') }}" class="flex items-center px-4 py-2.5 text-gray-700 transition-colors hover:bg-blue-50">
                                        <i class="mr-3 w-5 text-center text-gray-500 fas fa-user-circle"></i>
                                        <span>Mon profil</span>
                                    </a>
                                    <a href="{{ route('reservations.index') }}" class="flex items-center px-4 py-2.5 text-gray-700 transition-colors hover:bg-blue-50">
                                        <i class="mr-3 w-5 text-center text-gray-500 fas fa-ticket-alt"></i>
                                        <span>Mes réservations</span>
                                    </a>
                                    <div class="px-4 py-2.5 border-t border-gray-100/10">
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="flex items-center px-1 py-1.5 w-full text-left text-red-600 rounded transition-colors hover:bg-red-50">
                                                <i class="mr-3 w-5 text-center fas fa-sign-out-alt"></i>
                                                <span>Déconnexion</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="flex items-center ml-2 space-x-3">
                                <a href="{{ route('login') }}" class="flex items-center px-4 py-2 text-white rounded-lg transition-colors duration-300 hover:bg-white/10">
                                    <i class="mr-2 fas fa-sign-in-alt"></i>
                                    <span>Connexion</span>
                                </a>
                                <a href="{{ route('register') }}"
                                   class="flex items-center px-4 py-2 text-blue-600 bg-white rounded-lg shadow-md transition-colors duration-300 transform hover:bg-blue-50 hover:shadow-lg hover:-translate-y-0.5">
                                    <i class="mr-2 fas fa-user-plus"></i>
                                    <span class="font-medium">S'inscrire</span>
                                </a>
                            </div>
                        @endauth
                    </div>

                    <!-- Mobile menu button -->
                    <div class="flex items-center md:hidden">
                        <button id="mobile-menu-button" class="p-2 text-white rounded-lg transition-all duration-300 focus:outline-none hover:bg-white/10 focus:ring-2 focus:ring-white/50">
                            <i class="text-2xl fas fa-bars"></i>
                            <span class="sr-only">Ouvrir le menu</span>
                        </button>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Mobile menu -->
    <div id="mobile-menu" class="fixed inset-0 z-40 hidden w-full h-full bg-black/50 backdrop-blur-sm transition-opacity duration-300 ease-in-out">
        <div class="absolute right-0 w-4/5 h-full max-w-sm overflow-y-auto bg-gradient-to-b from-blue-900 to-blue-800 shadow-2xl transform transition-transform duration-300 ease-in-out translate-x-full">
            <div class="flex flex-col h-full">
                <div class="flex items-center justify-between p-4 border-b border-white/10">
                    <div class="flex items-center">
                        <i class="mr-2 text-blue-300 fas fa-plane"></i>
                        <span class="text-lg font-bold text-white">Menu</span>
                    </div>
                    <button id="mobile-menu-close" class="p-2 -mr-2 text-white rounded-full hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-white/50">
                        <i class="fas fa-times"></i>
                        <span class="sr-only">Fermer le menu</span>
                    </button>
                </div>
                
                <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
                    <a href="{{ route('home') }}" class="flex items-center px-4 py-3 text-white rounded-lg transition-all duration-300 hover:bg-white/10 group">
                        <i class="w-6 mr-3 text-center text-blue-300 fas fa-home group-hover:text-white"></i>
                        <span class="font-medium">Accueil</span>
                    </a>

                    <a href="{{ route('flights.search') }}" class="flex items-center px-4 py-3 text-white rounded-lg transition-all duration-300 hover:bg-white/10 group">
                        <i class="w-6 mr-3 text-center text-blue-300 fas fa-plane-departure group-hover:text-white"></i>
                        <span class="font-medium">Vols</span>
                    </a>

                    <a href="#" class="flex items-center px-4 py-3 text-white rounded-lg transition-all duration-300 hover:bg-white/10 group">
                        <i class="w-6 mr-3 text-center text-blue-300 fas fa-map-marked-alt group-hover:text-white"></i>
                        <span class="font-medium">Destinations</span>
                    </a>

                    <a href="#services" class="flex items-center px-4 py-3 text-white rounded-lg transition-all duration-300 hover:bg-white/10 group">
                        <i class="w-6 mr-3 text-center text-blue-300 fas fa-concierge-bell group-hover:text-white"></i>
                        <span class="font-medium">Services</span>
                    </a>

                    @auth
                        @if (Auth::user()->hasRole('gestionnaire'))
                            <a href="{{ route('manager.dashboard') }}" class="flex items-center px-4 py-3 text-white rounded-lg transition-all duration-300 hover:bg-white/10 group">
                                <i class="w-6 mr-3 text-center text-blue-300 fas fa-lock group-hover:text-white"></i>
                                <span class="font-medium">Back Office</span>
                            </a>
                        @endif
                    @endauth
                </nav>

                <div class="p-4 border-t border-white/10">
                    @auth
                        <div class="flex items-center p-3 mb-4 rounded-lg bg-white/5">
                            <div class="relative mr-3">
                                <img src="{{ Auth::user()->avatar ?? asset('images/default-avatar.png') }}"
                                     class="object-cover w-10 h-10 rounded-full border-2 border-white/20">
                                <span class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-green-400 rounded-full border-2 border-blue-900"></span>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-white">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-blue-200">{{ Auth::user()->email }}</p>
                            </div>
                        </div>

                        <a href="{{ route('profile.show') }}" class="flex items-center px-4 py-3 mb-2 text-white rounded-lg transition-all duration-300 hover:bg-white/10 group">
                            <i class="w-6 mr-3 text-center text-blue-300 fas fa-user-circle group-hover:text-white"></i>
                            <span class="font-medium">Mon profil</span>
                        </a>

                        <a href="{{ route('reservations.index') }}" class="flex items-center px-4 py-3 mb-2 text-white rounded-lg transition-all duration-300 hover:bg-white/10 group">
                            <i class="w-6 mr-3 text-center text-blue-300 fas fa-ticket-alt group-hover:text-white"></i>
                            <span class="font-medium">Mes réservations</span>
                        </a>

                        <form method="POST" action="{{ route('logout') }}" class="mt-4">
                            @csrf
                            <button type="submit" class="flex items-center w-full px-4 py-3 text-red-400 rounded-lg transition-colors hover:bg-red-500/10 group">
                                <i class="w-6 mr-3 text-center fas fa-sign-out-alt"></i>
                                <span class="font-medium">Déconnexion</span>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="flex items-center justify-center w-full px-4 py-3 mb-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="mr-2 fas fa-sign-in-alt"></i>
                            <span>Connexion</span>
                        </a>
                        <a href="{{ route('register') }}" class="flex items-center justify-center w-full px-4 py-3 text-blue-900 bg-white rounded-lg hover:bg-gray-100 transition-colors">
                            <i class="mr-2 fas fa-user-plus"></i>
                            <span class="font-medium">S'inscrire</span>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
    <div class="hidden fixed inset-0 z-40 backdrop-blur-sm mobile-menu md:hidden bg-blue-900/95">
        <div class="p-4">
            <div class="flex justify-end">
                <button class="text-white mobile-menu-close focus:outline-none">
                    <i class="text-2xl fas fa-times"></i>
                </button>
            </div>
            <div class="flex flex-col mt-8 space-y-4">
                <a href="{{ route('flights.search') }}" class="text-lg text-white">Vols</a>
                <a href="{{ route('public.destinations') }}" class="text-lg text-white">Destinations</a>
                <a href="#services" class="text-lg text-white">Services</a>
                @auth
                    <hr class="border-white/20">
                    <a href="{{ route('profile.show') }}" class="text-lg text-white">Mon profil</a>
                    <a href="{{ route('reservations.index') }}" class="text-lg text-white">Mes réservations</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-lg text-white">Déconnexion</button>
                    </form>
                @else
                    <hr class="border-white/20">
                    <a href="{{ route('login') }}" class="text-lg text-white">Connexion</a>
                    <a href="{{ route('register') }}" class="text-lg text-white">Inscription</a>
                @endauth
            </div>
        </div>
    </div>

    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="text-white bg-gray-900">
        <div class="px-4 py-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-8 md:grid-cols-4">
                <div>
                    <img src="{{ asset('images/logo.svg') }}" alt="Logo" class="h-12 w-auto brightness-150 drop-shadow-[0_0_15px_rgba(255,255,255,0.3)] transition-all duration-300 hover:brightness-125">
                    <p class="text-gray-400">Votre partenaire de confiance pour des voyages inoubliables</p>
                </div>

                <div>
                    <h3 class="mb-4 text-lg font-semibold">Liens rapides</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('flights.search') }}" class="text-gray-400 transition-colors hover:text-white">Rechercher un vol</a></li>
                        <li><a href="{{ route('public.destinations') }}" class="text-gray-400 transition-colors hover:text-white">Destinations</a></li>
                        <li><a href="#services" class="text-gray-400 transition-colors hover:text-white">Nos services</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="mb-4 text-lg font-semibold">Contact</h3>
                    <ul class="space-y-2">
                        <li class="flex items-center text-gray-400">
                            <i class="mr-2 fas fa-phone"></i>
                            +237 6 51 69 98 51
                        </li>
                        <li class="flex items-center text-gray-400">
                            <i class="mr-2 fas fa-envelope"></i>
                            contact@cronos.com
                        </li>
                        <li class="flex items-center text-gray-400">
                            <i class="mr-2 fas fa-map-marker-alt"></i>
                            Yaoudé, Cameroun
                        </li>
                    </ul>
                </div>

                <div>
                    <h3 class="mb-4 text-lg font-semibold">Suivez-nous</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 transition-colors hover:text-white">
                            <i class="text-2xl fab fa-facebook"></i>
                        </a>
                        <a href="#" class="text-gray-400 transition-colors hover:text-white">
                            <i class="text-2xl fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-gray-400 transition-colors hover:text-white">
                            <i class="text-2xl fab fa-instagram"></i>
                        </a>
                    </div>
                </div>
            </div>

            <hr class="my-8 border-gray-800">

            <div class="flex flex-col justify-between items-center md:flex-row">
                <p class="text-gray-400">&copy; {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.</p>
                <div class="flex mt-4 space-x-4 md:mt-0">
                    <a href="#" class="text-gray-400 transition-colors hover:text-white">Mentions légales</a>
                    <a href="#" class="text-gray-400 transition-colors hover:text-white">Politique de confidentialité</a>
                    <a href="#" class="text-gray-400 transition-colors hover:text-white">CGV</a>
                </div>
            </div>
        </div>
    </footer>
    <div id="monetbil-modal"></div>

    <!-- Scripts -->
    <script src="{{ asset('js/bootstrap.esm.min.js') }}"></script>
    <script src="{{ asset('js/axios.min.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="{{ asset('js/app.js') }}" type="module"></script>
    <!-- Particles.js -->
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script>
        // Gestion du menu mobile
        document.addEventListener('DOMContentLoaded', function () {
            const mobileMenu = document.getElementById('mobile-menu');
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenuClose = document.getElementById('mobile-menu-close');
            const mobileMenuPanel = mobileMenu.querySelector('div');

            let isAnimating = false;
            let isOpen = false;

            // Ouvrir le menu
            function openMobileMenu() {
                if (isAnimating || isOpen) return;
                isAnimating = true;
                isOpen = true;

                mobileMenu.classList.remove('hidden', 'opacity-0');
                void mobileMenu.offsetWidth; // force reflow
                mobileMenu.classList.add('opacity-100');
                mobileMenuPanel.classList.remove('translate-x-full');
                document.body.style.overflow = 'hidden';

                setTimeout(() => {
                    isAnimating = false;
                }, 300);
            }

            // Fermer le menu
            function closeMobileMenu() {
                if (isAnimating || !isOpen) return;
                isAnimating = true;
                isOpen = false;

                mobileMenuPanel.classList.add('translate-x-full');
                mobileMenu.classList.remove('opacity-100');
                mobileMenu.classList.add('opacity-0');
                document.body.style.overflow = '';

                setTimeout(() => {
                    if (mobileMenuPanel.classList.contains('translate-x-full')) {
                        mobileMenu.classList.add('hidden');
                    }
                    isAnimating = false;
                }, 300);
            }

            // Toggle menu
            function toggleMobileMenu() {
                if (isOpen) {
                    closeMobileMenu();
                } else {
                    openMobileMenu();
                }
            }

            // Événements
            mobileMenuButton.addEventListener('click', toggleMobileMenu);
            mobileMenuClose.addEventListener('click', closeMobileMenu);

            // Fermer en cliquant en dehors du panneau
            mobileMenu.addEventListener('click', function (e) {
                if (e.target === mobileMenu) {
                    closeMobileMenu();
                }
            });

            // Fermer avec la touche Échap
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && isOpen) {
                    closeMobileMenu();
                }
            });

            // Fermer lors du redimensionnement
            window.addEventListener('resize', function () {
                if (window.innerWidth >= 768) {
                    closeMobileMenu();
                }
            });
        });

        // Gestion du chat
        document.addEventListener('DOMContentLoaded', function() {
            const chatToggle = document.getElementById('chat-toggle');
            const chatWindow = document.getElementById('chat-window');
            const chatClose = document.getElementById('chat-close');
            const chatForm = document.getElementById('chat-form');
            const chatInput = document.getElementById('chat-input');
            const chatMessages = document.getElementById('chat-messages');

            // Toggle chat window
            if (chatToggle) {
                chatToggle.addEventListener('click', function(e) {
                    e.stopPropagation();
                    chatWindow.classList.toggle('hidden');
                    chatToggle.classList.toggle('rotate-90');
                });
            }

            // Close chat window
            if (chatClose) {
                chatClose.addEventListener('click', function(e) {
                    e.stopPropagation();
                    chatWindow.classList.add('hidden');
                    chatToggle.classList.remove('rotate-90');
                });
            }

            // Send message
            if (chatForm) {
                chatForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const message = chatInput.value.trim();
                    if (!message) return;

                    // Add user message to chat
                    addMessage(message, 'user');
                    chatInput.value = '';

                    // Show typing indicator
                    const typingIndicator = document.createElement('div');
                    typingIndicator.className = 'chat-message bot typing-indicator';
                    typingIndicator.innerHTML = `
                        <div class="inline-block p-3 bg-gray-100 rounded-lg">
                            <div class="flex space-x-2">
                                <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"></div>
                                <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                                <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.4s"></div>
                            </div>
                        </div>
                    `;
                    chatMessages.appendChild(typingIndicator);
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                    
                    // Send message to Open Router API
                    fetch('/api/v1/openrouter/chat', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                        },
                        body: JSON.stringify({ message: message })
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Remove typing indicator
                        const typingIndicators = document.querySelectorAll('.typing-indicator');
                        typingIndicators.forEach(indicator => indicator.remove());
                        
                        if (data.success) {
                            // Add bot response
                            addMessage(data.response, 'bot');
                        } else {
                            throw new Error('Erreur de l\'API');
                        }
                    })
                    .catch(error => {
                        console.error('Error sending message:', error);
                        
                        // Remove typing indicator
                        const typingIndicators = document.querySelectorAll('.typing-indicator');
                        typingIndicators.forEach(indicator => indicator.remove());
                        
                        // Add error message
                        addMessage("Désolé, une erreur est survenue. Veuillez réessayer plus tard.", 'bot');
                    });
                });
            }

            // Function to add a message to the chat
            function addMessage(text, sender) {
                const messageDiv = document.createElement('div');
                messageDiv.className = `chat-message ${sender}`;

                if (sender === 'user') {
                    messageDiv.innerHTML = `
                        <div class="flex justify-end">
                            <div class="inline-block p-3 max-w-xs text-white bg-blue-600 rounded-lg">
                                <p>${text}</p>
                            </div>
                        </div>
                    `;
                } else {
                    messageDiv.innerHTML = `
                        <div class="inline-block p-3 max-w-xs bg-gray-100 rounded-lg">
                            <p>${text}</p>
                        </div>
                    `;
                }

                chatMessages.appendChild(messageDiv);
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }
        });

        if (typeof particlesJS !== 'undefined' && document.getElementById('particles-js')) {
            particlesJS('particles-js', {
                particles: {
                    number: {
                        value: 80,
                        density: {
                            enable: true,
                            value_area: 800
                        }
                    },
                    color: {
                        value: '#ffffff'
                    },
                    opacity: {
                        value: 0.5,
                        random: true
                    },
                    size: {
                        value: 3,
                        random: true
                    },
                    line_linked: {
                        enable: true,
                        distance: 150,
                        color: '#ffffff',
                        opacity: 0.4,
                        width: 1
                    },
                    move: {
                        enable: true,
                        speed: 2,
                        direction: 'none',
                        random: true,
                        straight: false,
                        out_mode: 'out',
                        bounce: false
                    }
                },
                interactivity: {
                    detect_on: 'canvas',
                    events: {
                        onhover: {
                            enable: true,
                            mode: 'grab'
                        },
                        onclick: {
                            enable: true,
                            mode: 'push'
                        },
                        resize: true
                    },
                    modes: {
                        grab: {
                            distance: 140,
                            line_linked: {
                                opacity: 1
                            }
                        },
                        push: {
                            particles_nb: 4
                        }
                    }
                },
                retina_detect: true
            });
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chatToggle = document.getElementById('chat-toggle');
            const chatWindow = document.getElementById('chat-window');
            const chatClose = document.getElementById('chat-close');
            const chatForm = document.getElementById('chat-form');
            const chatInput = document.getElementById('chat-input');
            const chatMessages = document.getElementById('chat-messages');

            // Toggle chat window
            chatToggle.addEventListener('click', function() {
                chatWindow.classList.toggle('hidden');
                chatToggle.classList.toggle('rotate-90');
            });

            // Close chat window
            chatClose.addEventListener('click', function() {
                chatWindow.classList.add('hidden');
                chatToggle.classList.remove('rotate-90');
            });

            // Send message
            chatForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const message = chatInput.value.trim();
                if (!message) return;

                // Add user message to chat
                addMessage(message, 'user');
                chatInput.value = '';

                // Show typing indicator
                const typingIndicator = document.createElement('div');
                typingIndicator.className = 'chat-message bot typing-indicator';
                typingIndicator.innerHTML = `
                    <div class="inline-block p-3 bg-gray-100 rounded-lg">
                        <div class="flex space-x-2">
                            <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"></div>
                            <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                            <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.4s"></div>
                        </div>
                    </div>
                `;
                chatMessages.appendChild(typingIndicator);
                chatMessages.scrollTop = chatMessages.scrollHeight;
                
                // Send message to Open Router API
                fetch('/api/v1/openrouter/chat', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    },
                    body: JSON.stringify({ message: message })
                })
                .then(response => response.json())
                .then(data => {
                    // Remove typing indicator
                    const typingIndicators = document.querySelectorAll('.typing-indicator');
                    typingIndicators.forEach(indicator => indicator.remove());
                    
                    if (data.success) {
                        // Add bot response
                        addMessage(data.response, 'bot');
                    } else {
                        throw new Error('Erreur de l\'API');
                    }
                })
                .catch(error => {
                    console.error('Error sending message:', error);
                    
                    // Remove typing indicator
                    const typingIndicators = document.querySelectorAll('.typing-indicator');
                    typingIndicators.forEach(indicator => indicator.remove());
                    
                    // Add error message
                    addMessage("Désolé, une erreur est survenue. Veuillez réessayer plus tard.", 'bot');
                });
            });

            // Function to add a message to the chat
            function addMessage(text, sender) {
                const messageDiv = document.createElement('div');
                messageDiv.className = `chat-message ${sender}`;

                if (sender === 'user') {
                    messageDiv.innerHTML = `
                        <div class="flex justify-end">
                            <div class="inline-block p-3 max-w-xs text-white bg-blue-600 rounded-lg">
                                <p>${text}</p>
                            </div>
                        </div>
                    `;
                } else {
                    messageDiv.innerHTML = `
                        <div class="inline-block p-3 max-w-xs bg-gray-100 rounded-lg">
                            <p>${text}</p>
                        </div>
                    `;
                }

                chatMessages.appendChild(messageDiv);
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }
        });
    </script>

    <!-- Toastr JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        // Configuration de base de Toastr
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
    </script>
    @stack('scripts')
    @include('site.components.chat-widget')
</body>
</html>
