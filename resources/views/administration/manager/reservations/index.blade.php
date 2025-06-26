@extends('administration.layouts.app')

@section('title', 'Gestion des Réservations')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 align-self-center">
            <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Réservations</h3>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('manager.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Réservations</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="card-title">Liste des réservations</h4>
                        <div>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-filter me-1"></i> Filtrer par statut
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('manager.reservations.index') }}">Tous</a></li>
                                    <li><a class="dropdown-item" href="{{ route('manager.reservations.index', ['status' => 'pending']) }}">En attente</a></li>
                                    <li><a class="dropdown-item" href="{{ route('manager.reservations.index', ['status' => 'confirmed']) }}">Confirmées</a></li>
                                    <li><a class="dropdown-item" href="{{ route('manager.reservations.index', ['status' => 'cancelled']) }}">Annulées</a></li>
                                </ul>
                            </div>
                            <a href="#" class="btn btn-primary ms-2" onclick="window.print()">
                                <i class="fas fa-print me-1"></i> Imprimer
                            </a>
                        </div>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table id="reservations-table" class="table table-striped table-bordered no-wrap">
                            <thead>
                                <tr>
                                    <th>Référence</th>
                                    <th>Client</th>
                                    <th>Vol</th>
                                    <th>Date de réservation</th>
                                    <th>Passagers</th>
                                    <th>Montant</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reservations as $reservation)
                                    <tr>
                                        <td class="align-middle font-weight-medium">
                                            <a href="{{ route('manager.reservations.show', $reservation) }}" class="text-primary">
                                                {{ $reservation->reference }}
                                            </a>
                                        </td>
                                        <td class="align-middle">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm me-2 bg-light rounded-circle">
                                                    <span class="avatar-text">{{ substr($reservation->user->name, 0, 1) }}</span>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">{{ $reservation->user->name }}</h6>
                                                    <small class="text-muted">{{ $reservation->user->email }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <div>
                                                <span class="d-block">{{ $reservation->flight->flight_number }}</span>
                                                <small class="text-muted">
                                                    {{ $reservation->flight->departure }} → 
                                                    @if($reservation->flight->destination)
                                                        {{ $reservation->flight->destination->ville }}
                                                    @else
                                                        Destination inconnue
                                                    @endif
                                                </small>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            {{ \Carbon\Carbon::parse($reservation->created_at)->format('d/m/Y H:i') }}
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="badge bg-info rounded-pill">{{ $reservation->seat_number }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <span class="fw-bold">{{ number_format($reservation->price_paid, 0, ',', ' ') }} FCFA</span>
                                        </td>
                                        <td class="align-middle">
                                            @if($reservation->status == 'pending')
                                                <span class="badge bg-warning text-dark rounded-pill">En attente</span>
                                            @elseif($reservation->status == 'confirmed')
                                                <span class="badge bg-success rounded-pill">Confirmée</span>
                                            @elseif($reservation->status == 'cancelled')
                                                <span class="badge bg-danger rounded-pill">Annulée</span>
                                            @else
                                                <span class="badge bg-secondary rounded-pill">{{ $reservation->status }}</span>
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            <div class="dropdown">
                                                <button class="btn btn-link text-dark dropdown-toggle" type="button" id="dropdownMenuButton{{ $reservation->id }}" data-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton{{ $reservation->id }}">
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('manager.reservations.show', $reservation) }}">
                                                            <i class="fas fa-eye text-info me-2"></i> Détails
                                                        </a>
                                                    </li>
                                                    @if($reservation->status == 'pending')
                                                    <li>
                                                        <button class="dropdown-item confirm-reservation" data-id="{{ $reservation->id }}">
                                                            <i class="fas fa-check-circle text-success me-2"></i> Confirmer
                                                        </button>
                                                    </li>
                                                    @endif
                                                    @if($reservation->status != 'cancelled')
                                                    <li>
                                                        <button class="dropdown-item cancel-reservation" data-id="{{ $reservation->id }}">
                                                            <i class="fas fa-times-circle text-danger me-2"></i> Annuler
                                                        </button>
                                                    </li>
                                                    @endif
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <a class="dropdown-item" href="#" onclick="printReservation({{ $reservation->id }})">
                                                            <i class="fas fa-print text-primary me-2"></i> Imprimer
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <div class="d-flex flex-column align-items-center">
                                                <i class="fas fa-ticket-alt fa-3x text-muted mb-3"></i>
                                                <h5 class="text-muted">Aucune réservation trouvée</h5>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $reservations->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Confirm reservation
        $('.confirm-reservation').on('click', function() {
            const reservationId = $(this).data('id');
            
            Swal.fire({
                title: 'Confirmer la réservation ?',
                text: "Vous êtes sur le point de confirmer cette réservation",
                type: "question",
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Oui, confirmer',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading state
                    Swal.fire({
                        title: 'Traitement en cours...',
                        html: 'Veuillez patienter...',
                        allowOutsideClick: false,
                        willOpen: () => {
                            Swal.showLoading();
                        },
                    });

                    // Send update request
                    $.ajax({
                        url: `/manager/reservations/${reservationId}`,
                        type: 'PUT',
                        data: {
                            _token: '{{ csrf_token() }}',
                            status: 'confirmed'
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    title: 'Confirmée !',
                                    text: 'La réservation a été confirmée avec succès.',
                                    type: 'success',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(() => {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire({
                                    title: 'Attention !',
                                    text: response.message || 'Impossible de confirmer cette réservation.',
                                    type: 'warning',
                                    confirmButtonText: 'OK'
                                });
                            }
                        },
                        error: function(xhr) {
                            const response = xhr.responseJSON || {};
                            Swal.fire({
                                title: 'Erreur !',
                                text: response.message || 'Une erreur est survenue lors de la confirmation.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }
            });
        });

        // Cancel reservation
        $('.cancel-reservation').on('click', function() {
            const reservationId = $(this).data('id');
            
            Swal.fire({
                title: 'Annuler la réservation ?',
                text: "Vous êtes sur le point d'annuler cette réservation",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Oui, annuler',
                cancelButtonText: 'Retour'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading state
                    Swal.fire({
                        title: 'Traitement en cours...',
                        html: 'Veuillez patienter...',
                        allowOutsideClick: false,
                        willOpen: () => {
                            Swal.showLoading();
                        },
                    });

                    // Send update request
                    $.ajax({
                        url: `/manager/reservations/${reservationId}`,
                        type: 'PUT',
                        data: {
                            _token: '{{ csrf_token() }}',
                            status: 'cancelled'
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    title: 'Annulée !',
                                    text: 'La réservation a été annulée avec succès.',
                                    type: 'success',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(() => {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire({
                                    title: 'Attention !',
                                    text: response.message || 'Impossible d\'annuler cette réservation.',
                                    type: 'warning',
                                    confirmButtonText: 'OK'
                                });
                            }
                        },
                        error: function(xhr) {
                            const response = xhr.responseJSON || {};
                            Swal.fire({
                                title: 'Erreur !',
                                text: response.message || 'Une erreur est survenue lors de l\'annulation.',
                                type: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }
            });
        });
    });

    // Print individual reservation
    function printReservation(id) {
        const printWindow = window.open(`/manager/reservations/${id}/print`, '_blank');
        printWindow.addEventListener('load', function() {
            printWindow.print();
        });
    }
</script>
@endpush