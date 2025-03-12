@extends('site.layouts.app')

@section('content')
<div class="min-h-screen pt-40 bg-gray-50 py-8">
    <div class="max-w-xl mx-auto">
        <!-- En-tête -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-t-2xl p-6 text-center">
            <div class="w-16 h-16 bg-white rounded-full mx-auto mb-4 flex items-center justify-center">
                <i class="fas fa-key text-blue-600 text-2xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-white mb-2">Changer le mot de passe</h1>
            <p class="text-blue-100">Sécurisez votre compte avec un nouveau mot de passe</p>
        </div>

        <!-- Formulaire -->
        <div class="bg-white rounded-b-2xl shadow-lg p-8">
            <form method="POST" action="{{ route('profile.password.post') }}" class="space-y-6">
                @csrf
                <!-- Mot de passe actuel -->
                <div class="space-y-2">
                    <label for="current_password" class="flex items-center text-sm font-medium text-gray-700">
                        <i class="fas fa-lock text-blue-600 mr-2"></i>
                        Mot de passe actuel
                    </label>
                    <div class="relative">
                        <input type="password" 
                               name="current_password" 
                               id="current_password" 
                               class="w-full pl-4 pr-10 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors" 
                               required>
                        <button type="button" 
                                class="toggle-password absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- Nouveau mot de passe -->
                <div class="space-y-2">
                    <label for="new_password" class="flex items-center text-sm font-medium text-gray-700">
                        <i class="fas fa-key text-blue-600 mr-2"></i>
                        Nouveau mot de passe
                    </label>
                    <div class="relative">
                        <input type="password" 
                               name="new_password" 
                               id="new_password" 
                               class="w-full pl-4 pr-10 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors" 
                               required>
                        <button type="button" 
                                class="toggle-password absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <button type="button" 
                            id="generate_password" 
                            class="mt-2 inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                        <i class="fas fa-magic mr-2"></i>
                        Générer un mot de passe sécurisé
                    </button>
                </div>

                <!-- Confirmation du nouveau mot de passe -->
                <div class="space-y-2">
                    <label for="new_password_confirmation" class="flex items-center text-sm font-medium text-gray-700">
                        <i class="fas fa-check-circle text-blue-600 mr-2"></i>
                        Confirmer le nouveau mot de passe
                    </label>
                    <div class="relative">
                        <input type="password" 
                               name="new_password_confirmation" 
                               id="new_password_confirmation" 
                               class="w-full pl-4 pr-10 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors" 
                               required>
                        <button type="button" 
                                class="toggle-password absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" 
                            class="w-full inline-flex items-center justify-center px-6 py-3 bg-blue-600 text-white font-medium rounded-xl hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        <i class="fas fa-save mr-2"></i>
                        Mettre à jour le mot de passe
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal de génération de mot de passe -->
<div id="modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-2xl shadow-xl max-w-md w-full mx-4 transform transition-all">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-900">Mot de passe généré</h2>
                <button id="close_modal" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="bg-gray-50 rounded-xl p-4 mb-4">
                <div class="relative">
                    <input type="text" 
                           id="generated_password" 
                           class="w-full pl-4 pr-10 py-3 bg-white border border-gray-200 rounded-lg" 
                           readonly>
                    <button id="copy_password" 
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600"
                            title="Copier le mot de passe">
                        <i class="fas fa-copy"></i>
                    </button>
                </div>
            </div>

            <div class="flex space-x-3">
                <button id="confirm_password" 
                        class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-check mr-2"></i>Utiliser ce mot de passe
                </button>
                <button id="regenerate_password" 
                        class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                    <i class="fas fa-sync-alt"></i>
                </button>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Fonction pour générer un mot de passe fort
    function generateStrongPassword() {
        const length = 12;
        const charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+";
        let password = "";
        for (let i = 0; i < length; i++) {
            password += charset.charAt(Math.floor(Math.random() * charset.length));
        }
        return password;
    }

    // Gestionnaire pour afficher/masquer le mot de passe
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function() {
            const input = this.parentElement.querySelector('input');
            const icon = this.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });

    // Gestionnaires pour le modal
    document.getElementById('generate_password').addEventListener('click', function() {
        document.getElementById('generated_password').value = generateStrongPassword();
        document.getElementById('modal').classList.remove('hidden');
    });

    document.getElementById('regenerate_password').addEventListener('click', function() {
        document.getElementById('generated_password').value = generateStrongPassword();
    });

    document.getElementById('copy_password').addEventListener('click', function() {
        const passwordField = document.getElementById('generated_password');
        passwordField.select();
        document.execCommand('copy');
        
        // Feedback visuel
        this.innerHTML = '<i class="fas fa-check"></i>';
        setTimeout(() => {
            this.innerHTML = '<i class="fas fa-copy"></i>';
        }, 1000);
    });

    document.getElementById('confirm_password').addEventListener('click', function() {
        const password = document.getElementById('generated_password').value;
        document.getElementById('new_password').value = password;
        document.getElementById('new_password_confirmation').value = password;
        document.getElementById('modal').classList.add('hidden');
    });

    document.getElementById('close_modal').addEventListener('click', function() {
        document.getElementById('modal').classList.add('hidden');
    });

    // Fermer le modal en cliquant en dehors
    document.getElementById('modal').addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.add('hidden');
        }
    });
});
</script>
@endpush
@endsection