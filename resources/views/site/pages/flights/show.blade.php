@extends('site.layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow-xl rounded-lg overflow-hidden">
        <div class="p-6">
            <div class="flex items-center justify-between mb-8">
                <h1 class="text-2xl font-bold text-gray-900">Détails du Vol</h1>
                <span class="px-4 py-2 rounded-full text-sm font-semibold 
                    {{ $flight->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $flight->status === 'active' ? 'Actif' : 'Annulé' }}
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Numéro de vol</h3>
                        <p class="mt-1 text-lg font-semibold text-gray-900">{{ $flight->flight_number }}</p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Départ</h3>
                        <p class="mt-1 text-lg font-semibold text-gray-900">{{ $flight->departure }}</p>
                        <p class="text-sm text-gray-500">{{ $flight->departure_time->format('d M Y H:i') }}</p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Destination</h3>
                        <p class="mt-1 text-lg font-semibold text-gray-900">{{ $flight->destination }}</p>
                        <p class="text-sm text-gray-500">{{ $flight->arrival_time->format('d M Y H:i') }}</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Prix</h3>
                        <p class="mt-1 text-2xl font-bold text-indigo-600">{{ number_format($flight->price, 0, ',', ' ') }} FCFA</p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Places disponibles</h3>
                        <p class="mt-1 text-lg font-semibold text-gray-900">{{ $flight->available_seats }} / {{ $flight->total_seats }}</p>
                    </div>

                    @if($flight->isAvailable())
                        <div class="mt-6">
                            <a href="{{ route('reservations.create', $flight) }}" 
                               class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Réserver maintenant
                            </a>
                        </div>
                    @else
                        <div class="mt-6">
                            <p class="text-red-600 font-medium">Ce vol n'est plus disponible à la réservation.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Informations supplémentaires -->
    <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">
                                Durée du vol
                            </dt>
                            <dd class="flex items-baseline">
                                <div class="text-lg font-semibold text-gray-900">
                                    {{ $flight->departure_time->diffInHours($flight->arrival_time) }}h {{ $flight->departure_time->diffInMinutes($flight->arrival_time) % 60 }}min
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">
                                Moyens de paiement
                            </dt>
                            <dd class="flex items-baseline">
                                <div class="text-sm text-gray-900">
                                    Orange Money, Mobile Money, Carte bancaire
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
