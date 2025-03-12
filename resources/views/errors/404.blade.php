<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page non trouvée - Votre Agence Aérienne</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-b from-blue-50 to-blue-100 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-3xl mx-auto text-center">
        <div class="relative">
            <!-- Illustration d'avion -->
            <div class="mb-8">
                <svg class="w-48 h-48 mx-auto text-blue-600 animate-bounce" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 7V5a2 2 0 012-2h2M7 3h10a2 2 0 012 2v2M17 3v2a2 2 0 002 2h2M21 7v10a2 2 0 01-2 2h-2M19 21h-2a2 2 0 01-2-2v-2M15 21H5a2 2 0 01-2-2V9" />
                </svg>
            </div>

            <!-- Message d'erreur -->
            <div class="space-y-6">
                <h1 class="text-6xl font-bold text-blue-600">404</h1>
                <h2 class="text-3xl font-semibold text-gray-800">Destination non trouvée</h2>
                <p class="text-gray-600 text-xl">Désolé, cette page semble avoir pris un autre vol !</p>
                
                <!-- Détails supplémentaires -->
                <div class="mt-8 text-gray-500">
                    <p>Il semble que vous ayez pris une mauvaise direction.</p>
                    <p>Laissez-nous vous rediriger vers votre destination.</p>
                </div>

                <!-- Boutons -->
                <div class="mt-10 space-x-4">
                    <a href="/" class="inline-block px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition duration-300">
                        Retour à l'accueil
                    </a>
                    <a href="javascript:history.back()" class="inline-block px-6 py-3 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition duration-300">
                        Page précédente
                    </a>
                </div>
            </div>

            <!-- Éléments décoratifs -->
            <div class="absolute top-0 left-0 w-full h-full pointer-events-none">
                <div class="absolute top-10 left-10 w-4 h-4 bg-blue-200 rounded-full animate-ping"></div>
                <div class="absolute bottom-10 right-10 w-4 h-4 bg-blue-300 rounded-full animate-ping animation-delay-1000"></div>
            </div>
        </div>
    </div>
</body>
</html>