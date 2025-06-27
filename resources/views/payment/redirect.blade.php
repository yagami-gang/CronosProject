<!DOCTYPE html>
<html>
<head>
    <title>Redirection vers le paiement - {{ config('app.name') }}</title>
    <meta http-equiv="refresh" content="3;url={{ $paymentUrl }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .loader {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 2s linear infinite;
            margin: 20px auto;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg p-8 text-center">
        <div class="mb-6">
            <div class="loader"></div>
        </div>
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Redirection en cours...</h1>
        <p class="text-gray-600 mb-6">Vous allez être redirigé vers la page de paiement sécurisé.</p>
        
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 text-left">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-blue-700">
                        Si la redirection ne se fait pas automatiquement, 
                        <a href="{{ $paymentUrl }}" class="font-medium underline text-blue-700 hover:text-blue-600">cliquez ici</a>.
                    </p>
                </div>
            </div>
        </div>
        
        <div class="mt-6 pt-6 border-t border-gray-200">
            <p class="text-sm text-gray-500">
                En cas de problème, contactez notre service client à 
                <a href="mailto:support@example.com" class="text-blue-600 hover:underline">support@example.com</a>
            </p>
        </div>
    </div>
</body>
</html>
