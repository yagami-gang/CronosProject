@extends('site.layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow-xl rounded-lg overflow-hidden">
        <div class="p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-8">Paiement de votre réservation</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Résumé de la réservation -->
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Résumé de la réservation</h3>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Vol</span>
                            <span class="font-medium">{{ $reservation->flight->flight_number }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600">Trajet</span>
                            <span class="font-medium">{{ $reservation->flight->departure }} → {{ $reservation->flight->destination }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600">Date</span>
                            <span class="font-medium">{{ $reservation->flight->departure_time->format('d M Y H:i') }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600">Siège</span>
                            <span class="font-medium">{{ $reservation->seat_number }}</span>
                        </div>
                        
                        <div class="pt-4 border-t">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-medium">Total à payer</span>
                                <span class="text-2xl font-bold text-indigo-600">{{ number_format($reservation->price_paid, 0, ',', ' ') }} FCFA</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Formulaire de paiement -->
                <div>
                    <form action="{{ route('payments.store', $reservation) }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Choisir votre moyen de paiement
                            </label>
                            
                            <div class="space-y-4">
                                <div class="relative flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="orange_money" name="payment_method" type="radio" value="orange_money" required
                                            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="orange_money" class="font-medium text-gray-700">Orange Money</label>
                                    </div>
                                </div>
                                
                                <div class="relative flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="mobile_money" name="payment_method" type="radio" value="mobile_money"
                                            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="mobile_money" class="font-medium text-gray-700">Mobile Money</label>
                                    </div>
                                </div>
                                
                                <div class="relative flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="card" name="payment_method" type="radio" value="card"
                                            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="card" class="font-medium text-gray-700">Carte bancaire</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Champs dynamiques selon le moyen de paiement -->
                        <div id="mobile_payment_fields" class="space-y-4 hidden">
                            <div>
                                <label for="phone_number" class="block text-sm font-medium text-gray-700">
                                    Numéro de téléphone
                                </label>
                                <input type="tel" name="phone_number" id="phone_number" 
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    placeholder="237 6XX XXX XXX">
                            </div>
                        </div>

                        <div id="card_payment_fields" class="space-y-4 hidden">
                            <div>
                                <label for="card_number" class="block text-sm font-medium text-gray-700">
                                    Numéro de carte
                                </label>
                                <input type="text" name="card_number" id="card_number" 
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    placeholder="XXXX XXXX XXXX XXXX">
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="expiry_date" class="block text-sm font-medium text-gray-700">
                                        Date d'expiration
                                    </label>
                                    <input type="text" name="expiry_date" id="expiry_date" 
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        placeholder="MM/YY">
                                </div>
                                
                                <div>
                                    <label for="cvv" class="block text-sm font-medium text-gray-700">
                                        CVV
                                    </label>
                                    <input type="text" name="cvv" id="cvv" 
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        placeholder="XXX">
                                </div>
                            </div>
                        </div>

                        <div>
                            <button type="submit"
                                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Payer maintenant
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
        const mobileFields = document.getElementById('mobile_payment_fields');
        const cardFields = document.getElementById('card_payment_fields');

        paymentMethods.forEach(method => {
            method.addEventListener('change', function() {
                mobileFields.classList.add('hidden');
                cardFields.classList.add('hidden');

                if (this.value === 'orange_money' || this.value === 'mobile_money') {
                    mobileFields.classList.remove('hidden');
                } else if (this.value === 'card') {
                    cardFields.classList.remove('hidden');
                }
            });
        });
    });
</script>
@endpush
@endsection
