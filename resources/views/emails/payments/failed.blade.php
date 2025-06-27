@extends('layouts.email')

@section('content')
    <div class="email-container">
        <h2>Échec du paiement - Réservation #{{ $reservation->id }}</h2>
        
        <p>Bonjour {{ $reservation->user->name }},</p>
        
        <p>Malheureusement, nous n'avons pas pu traiter votre paiement pour la réservation suivante :</p>
        
        <div class="reservation-details">
            <p><strong>Référence :</strong> {{ $reservation->reference }}</p>
            <p><strong>Date de voyage :</strong> {{ $reservation->travel_date->format('d/m/Y') }}</p>
            <p><strong>Nombre de passagers :</strong> {{ $reservation->passengers_count }}</p>
            <p><strong>Montant dû :</strong> {{ number_format($reservation->amount, 0, ',', ' ') }} FCFA</p>
        </div>
        
        <p><strong>Raison de l'échec :</strong> Votre paiement n'a pas pu être traité. Cela peut être dû à un problème technique ou à un rejet de votre opérateur mobile.</p>
        
        <p>Pour réessayer le paiement, veuillez cliquer sur le bouton ci-dessous :</p>
        
        <div class="cta">
            <a href="{{ route('reservations.show', $reservation) }}" class="button">Réessayer le paiement</a>
        </div>
        
        <p>Si le problème persiste, veuillez contacter notre service client dès que possible au [numéro de téléphone] ou par email à [adresse email].</p>
        
        <p>Nous sommes désolés pour ce désagrément et restons à votre disposition pour toute assistance.</p>
        
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
            background-color: #e3342f;
            color: white !important;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
@endsection
