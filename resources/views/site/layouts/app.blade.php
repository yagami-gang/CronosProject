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
    <!-- Particles.js -->
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script>
        // Attendre que le DOM soit complètement chargé
        document.addEventListener('DOMContentLoaded', function() {
            // Configuration de particles.js
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
        });

        // Mobile menu
        document.querySelector('.mobile-menu-button').addEventListener('click', function() {
            document.querySelector('.mobile-menu').classList.remove('hidden');
        });

        document.querySelector('.mobile-menu-close').addEventListener('click', function() {
            document.querySelector('.mobile-menu').classList.add('hidden');
        });

        // Configuration de particles.js déplacée en haut du script
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
                    <div class="bg-gray-100 rounded-lg p-3 inline-block">
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
                            <div class="bg-blue-600 text-white rounded-lg p-3 inline-block max-w-xs">
                                <p>${text}</p>
                            </div>
                        </div>
                    `;
                } else {
                    messageDiv.innerHTML = `
                        <div class="bg-gray-100 rounded-lg p-3 inline-block max-w-xs">
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
    <script type="text/javascript" src="https://fr.monetbil.com/widget/v2/monetbil.min.js"></script>
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