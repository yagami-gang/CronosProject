@extends('layouts.email')

@section('content')
    <div class="email-container">
        <h2>Confirmation de votre réservation #{{ $reservation->id }}</h2>
        
        <p>Bonjour {{ $reservation->user->name }},</p>
        
        <p>Nous avons le plaisir de vous confirmer votre réservation pour le vol suivant :</p>
        
        <div class="reservation-details">
            <p><strong>Référence :</strong> {{ $reservation->reference }}</p>
            <p><strong>Date de voyage :</strong> {{ $reservation->travel_date->format('d/m/Y') }}</p>
            <p><strong>Nombre de passagers :</strong> {{ $reservation->passengers_count }}</p>
            <p><strong>Montant payé :</strong> {{ number_format($reservation->amount, 0, ',', ' ') }} FCFA</p>
            <p><strong>Statut :</strong> Paiement confirmé</p>
        </div>
        
        <p>Vous pouvez consulter les détails de votre réservation à tout moment en vous connectant à votre compte.</p>
        
        <div class="cta">
            <a href="{{ route('reservations.show', $reservation) }}" class="button">Voir ma réservation</a>
        </div>
        
        <p>Merci de votre confiance et bon voyage !</p>
        
        <p>Cordialement,<br>L'équipe de [Nom de votre compagnie]</p>
    </div>

    <style>
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .reservation-details {
            background-color: #f5f5f5;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #3490dc;
            color: white !important;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
@endsection
