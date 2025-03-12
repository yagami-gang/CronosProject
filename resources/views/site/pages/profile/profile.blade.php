@extends('site.layouts.app')

@section('content')
<div class="min-h-screen pt-20 bg-gray-50 py-8">
    <div class="max-w-4xl mt-5 mx-auto">
        <!-- En-tête du profil -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-t-2xl p-6 md:p-8">
            <div class="flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-6">
                <div class="relative group">
                    <div class="w-24 h-24 md:w-32 md:h-32 rounded-full overflow-hidden border-4 border-white shadow-lg">
                        <svg class="w-full h-full text-gray-300" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            @if(Auth::user()->avatar)
                                <image href="{{ Auth::user()->avatar }}" width="24" height="24"/>
                            @else
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/>
                            @endif
                        </svg>
                    </div>
                    <label class="absolute bottom-0 right-0 bg-white rounded-full p-2 shadow-lg cursor-pointer hover:bg-gray-50 transition">
                        <i class="fas fa-camera text-blue-600"></i>
                        <input type="file" class="hidden" name="avatar" accept="image/*">
                    </label>
                </div>
                <div class="text-center md:text-left">
                    <h1 class="text-2xl md:text-3xl font-bold text-white">{{ Auth::user()->name }}</h1>
                    <p class="text-blue-100">Membre depuis {{ Auth::user()->created_at->format('F Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Contenu du profil -->
        <div class="bg-white rounded-b-2xl shadow-lg p-6 md:p-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Formulaire principal -->
                <div class="md:col-span-2">
                    <form method="POST" action="{{ route('profile.update') }}" class="space-y-6" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="avatar" id="avatar-upload" class="hidden" accept="image/*">
                        
                        <!-- Informations personnelles -->
                        <div class="bg-gray-50 rounded-xl p-6">
                            <h2 class="text-lg font-semibold text-gray-900 mb-4">Informations personnelles</h2>
                            <div class="space-y-4">
                                <div class="form-group">
                                    <div class="flex items-center mb-2">
                                        <i class="fas fa-user text-blue-600 mr-2"></i>
                                        <label for="name" class="text-sm font-medium text-gray-700">Nom complet</label>
                                    </div>
                                    <input type="text" name="name" id="name" 
                                           value="{{ Auth::user()->name }}" 
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                                           required>
                                </div>

                                <div class="form-group">
                                    <div class="flex items-center mb-2">
                                        <i class="fas fa-envelope text-blue-600 mr-2"></i>
                                        <label for="email" class="text-sm font-medium text-gray-700">Adresse email</label>
                                    </div>
                                    <input type="email" name="email" id="email" 
                                           value="{{ Auth::user()->email }}" 
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                                           required>
                                </div>

                                <div class="form-group">
                                    <div class="flex items-center mb-2">
                                        <i class="fas fa-phone text-blue-600 mr-2"></i>
                                        <label for="phone" class="text-sm font-medium text-gray-700">Téléphone</label>
                                    </div>
                                    <input type="tel" name="phone" id="phone" 
                                           value="{{ Auth::user()->phone }}" 
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                </div>

                                <div class="form-group">
                                    <div class="flex items-center mb-2">
                                        <i class="fas fa-map-marker-alt text-blue-600 mr-2"></i>
                                        <label for="address" class="text-sm font-medium text-gray-700">Adresse</label>
                                    </div>
                                    <textarea name="address" id="address" rows="3" 
                                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">{{ Auth::user()->address }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" 
                                    class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                <i class="fas fa-save mr-2"></i>
                                Enregistrer les modifications
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Actions rapides -->
                    <div class="bg-gray-50 rounded-xl p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions rapides</h3>
                        <div class="space-y-3">
                            <a href="{{ route('profile.password.get') }}" 
                               class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                                <i class="fas fa-key text-blue-600 mr-3"></i>
                                Changer le mot de passe
                            </a>
                            <a href="{{ route('reservations.index') }}" 
                               class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                                <i class="fas fa-ticket-alt text-blue-600 mr-3"></i>
                                Mes réservations
                            </a>
                        </div>
                    </div>

                    <!-- Statistiques -->
                    <div class="bg-gray-50 rounded-xl p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Mes statistiques</h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Vols réservés</span>
                                <span class="font-semibold">{{ Auth::user()->reservations_count ?? 0 }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Points fidélité</span>
                                <span class="font-semibold">{{ Auth::user()->loyalty_points ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const avatarInput = document.getElementById('avatar-upload');
    const avatarImage = document.querySelector('.w-24.h-24 img');
    
    avatarInput.addEventListener('change', function(e) {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                avatarImage.src = e.target.result;
            }
            
            reader.readAsDataURL(this.files[0]);
        }
    });
});
</script>
@endpush
