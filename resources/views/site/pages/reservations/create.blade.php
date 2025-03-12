@extends('site.layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-indigo-600 to-blue-500 mb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="text-center">
                <h1 class="text-4xl font-extrabold text-white mb-2">Réservation de vol</h1>
                <p class="text-indigo-100">Complétez votre réservation en quelques étapes simples</p>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
            <!-- Progress Steps -->
            <div class="border-b border-gray-200">
                <div class="flex justify-center p-4">
                    <div class="flex items-center space-x-8">
                        <div class="flex items-center">
                            <span class="w-8 h-8 flex items-center justify-center rounded-full bg-indigo-600 text-white font-semibold">1</span>
                            <span class="ml-2 text-sm font-medium text-gray-900">Détails du vol</span>
                        </div>
                        <div class="h-px w-16 bg-indigo-600"></div>
                        <div class="flex items-center">
                            <span class="w-8 h-8 flex items-center justify-center rounded-full bg-indigo-100 text-indigo-600 font-semibold">2</span>
                            <span class="ml-2 text-sm font-medium text-gray-500">Paiement</span>
                        </div>
                        <div class="h-px w-16 bg-gray-200"></div>
                        <div class="flex items-center">
                            <span class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 text-gray-500 font-semibold">3</span>
                            <span class="ml-2 text-sm font-medium text-gray-500">Confirmation</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                    <!-- Détails du vol -->
                    <div>
                        <div class="bg-gradient-to-br from-indigo-50 to-blue-50 rounded-xl p-6 border border-indigo-100">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-xl font-bold text-gray-900">Détails du vol</h3>
                                <span class="px-4 py-1 bg-indigo-100 text-indigo-700 rounded-full text-sm font-medium">{{ $flight->flight_number }}</span>
                            </div>

                            <div class="flex items-center justify-between mb-8">
                                <div class="text-center">
                                    <div class="text-3xl font-bold text-gray-900">{{ $flight->departure_city }}</div>
                                    <div class="text-sm text-gray-500">{{ $flight->departure_time->format('H:i') }}</div>
                                    <div class="text-xs text-gray-400">{{ $flight->departure_time->format('d M Y') }}</div>
                                </div>

                                <div class="flex-1 px-8 relative">
                                    <div class="h-0.5 bg-indigo-500 w-full absolute top-1/2"></div>
                                    <div class="flex justify-center">
                                        <span class="bg-white p-2 rounded-full">
                                            <i class="fas fa-plane text-indigo-500 transform rotate-90"></i>
                                        </span>
                                    </div>
                                    <div class="text-center text-xs text-gray-500 mt-2">
                                        {{ $flight->duration }} min
                                    </div>
                                </div>

                                <div class="text-center">
                                    <div class="text-3xl font-bold text-gray-900">{{ $flight->arrival_city }}</div>
                                    <div class="text-sm text-gray-500">{{ $flight->arrival_time->format('H:i') }}</div>
                                    <div class="text-xs text-gray-400">{{ $flight->arrival_time->format('d M Y') }}</div>
                                </div>
                            </div>

                            <div class="border-t border-indigo-100 pt-6">
                                <div class="grid grid-cols-3 gap-4">
                                    <div>
                                        <div class="text-sm text-gray-500">Classe</div>
                                        <div class="font-medium">{{ $flight->class }}</div>
                                    </div>
                                    <div>
                                        <div class="text-sm text-gray-500">Places disponibles</div>
                                        <div class="font-medium">{{ $flight->available_seats }}</div>
                                    </div>
                                    <div>
                                        <div class="text-sm text-gray-500">Prix</div>
                                        <div class="text-2xl font-bold text-indigo-600">{{ number_format($flight->price, 0, ',', ' ') }} FCFA</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Informations importantes -->
                        <div class="mt-8 bg-yellow-50 border border-yellow-100 rounded-xl p-6">
                            <h4 class="flex items-center text-lg font-medium text-yellow-800 mb-4">
                                <i class="fas fa-info-circle mr-2"></i>
                                Informations importantes
                            </h4>
                            <ul class="space-y-3">
                                <li class="flex items-start">
                                    <i class="fas fa-clock text-yellow-600 mt-1 mr-3"></i>
                                    <span class="text-yellow-800">Arrivez à l'aéroport 2 heures avant le départ</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-id-card text-yellow-600 mt-1 mr-3"></i>
                                    <span class="text-yellow-800">Carte d'identité ou passeport obligatoire</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-suitcase text-yellow-600 mt-1 mr-3"></i>
                                    <span class="text-yellow-800">Bagages en soute : max 23kg</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Formulaire de réservation -->
                    <div>
                        <form action="{{ route('reservations.store', $flight) }}" method="POST" class="space-y-8">
                            @csrf
                            
                            <!-- Sélection des sièges -->
                            <div class="bg-white rounded-xl border border-gray-200 p-6">
                                <h3 class="text-lg font-bold text-gray-900 mb-4">Sélection du siège</h3>
                                <div class="grid grid-cols-6 gap-2">
                                    @foreach($available_seats as $seat)
                                    <div>
                                        <input type="radio" name="seat_number" id="seat_{{ $seat }}" value="{{ $seat }}" class="hidden peer" required>
                                        <label for="seat_{{ $seat }}" class="flex items-center justify-center p-2 border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-indigo-500 peer-checked:bg-indigo-50 hover:bg-gray-50">
                                            {{ $seat }}
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Options supplémentaires -->
                            <div class="bg-white rounded-xl border border-gray-200 p-6">
                                <h3 class="text-lg font-bold text-gray-900 mb-4">Options supplémentaires</h3>
                                <div class="space-y-4">
                                    <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                                        <input type="checkbox" name="extra_baggage" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                        <span class="ml-3">
                                            <span class="block text-sm font-medium text-gray-900">Bagage supplémentaire</span>
                                            <span class="block text-sm text-gray-500">+15,000 FCFA</span>
                                        </span>
                                    </label>
                                    <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                                        <input type="checkbox" name="priority_boarding" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                        <span class="ml-3">
                                            <span class="block text-sm font-medium text-gray-900">Embarquement prioritaire</span>
                                            <span class="block text-sm text-gray-500">+5,000 FCFA</span>
                                        </span>
                                    </label>
                                </div>
                            </div>

                            <!-- Conditions et validation -->
                            <div class="bg-gray-50 rounded-xl p-6">
                                <div class="flex items-start mb-6">
                                    <div class="flex items-center h-5">
                                        <input id="terms" name="terms" type="checkbox" required class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="terms" class="font-medium text-gray-700">J'accepte les conditions générales</label>
                                        <p class="text-gray-500">En cochant cette case, vous acceptez nos <a href="#" class="text-indigo-600 hover:text-indigo-500">conditions d'utilisation</a> et notre <a href="#" class="text-indigo-600 hover:text-indigo-500">politique de confidentialité</a>.</p>
                                    </div>
                                </div>

                                <button type="submit" class="w-full flex items-center justify-center px-8 py-4 border border-transparent text-base font-medium rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <i class="fas fa-lock mr-2"></i>
                                    Procéder au paiement
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush
