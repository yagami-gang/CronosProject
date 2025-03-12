@extends('administration.layouts.app')

@section('title', 'Gestion des Vols')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 align-self-center">
            <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Vols</h3>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('manager.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Vols</li>
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
                        <h4 class="card-title">Liste des vols</h4>
                        <a href="{{ route('manager.flights.create') }}" class="btn btn-primary rounded-pill">
                            <i class="fas fa-plus-circle mr-1"></i> Nouveau vol
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table id="flights-table" class="table table-striped table-bordered no-wrap">
                            <thead>
                                <tr>
                                    <th>Numéro de vol</th>
                                    <th>Départ</th>
                                    <th>Destination</th>
                                    <th>Date & Heure départ</th>
                                    <th>Date & Heure arrivée</th>
                                    <th>Prix</th>
                                    <th>Capacité</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($flights as $flight)
                                    <tr>
                                        <td class="align-middle">{{ $flight->flight_number }}</td>
                                        <td class="align-middle">{{ $flight->departure }}</td>
                                        <td class="align-middle">
                                            @if($flight->destination)
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ $flight->destination->getImageUrlComplete() }}" 
                                                        alt="{{ $flight->destination->ville }}" 
                                                        class="rounded-circle mr-2"
                                                        width="30" height="30">
                                                    <span>{{ $flight->destination->ville }}</span>
                                                </div>
                                            @else
                                                <span class="text-muted">Non définie</span>
                                            @endif
                                        </td>
                                        <td class="align-middle">{{ \Carbon\Carbon::parse($flight->departure_time)->format('d/m/Y H:i') }}</td>
                                        <td class="align-middle">{{ \Carbon\Carbon::parse($flight->arrival_time)->format('d/m/Y H:i') }}</td>
                                        <td class="align-middle">{{ number_format($flight->price, 0, ',', ' ') }} €</td>
                                        <td class="align-middle">{{ $flight->total_seats }} places</td>
                                        <td class="align-middle">
                                            <span class="badge badge-pill badge-{{ $flight->status === 'planifié' ? 'primary' : ($flight->status === 'confirmé' ? 'success' : 'danger') }} rounded-pill">
                                                {{ ucfirst($flight->status) }}
                                            </span>
                                        </td>
                                        <td class="align-middle">
                                            <div class="dropdown">
                                                <button class="btn btn-link text-dark dropdown-toggle" type="button" id="dropdownMenuButton{{ $flight->id }}" data-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton{{ $flight->id }}">
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('manager.flights.edit', $flight) }}">
                                                            <i class="fas fa-edit text-info me-2"></i> Modifier
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <button class="dropdown-item text-danger delete-flight" 
                                                                data-id="{{ $flight->id }}"
                                                                data-number="{{ $flight->flight_number }}">
                                                            <i class="fas fa-trash-alt me-2"></i> Supprimer
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-4">
                                            <div class="d-flex flex-column align-items-center">
                                                <i class="fas fa-plane fa-3x text-muted mb-3"></i>
                                                <h5 class="text-muted">Aucun vol trouvé</h5>
                                                <a href="{{ route('manager.flights.create') }}" class="btn btn-primary mt-3">
                                                    <i class="fas fa-plus-circle mr-1"></i> Ajouter un vol
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $flights->links() }}
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
            // Delete flight handling
            $('.delete-flight').on('click', function() {
                const flightId = $(this).data('id');
                const flightNumber = $(this).data('number');

                Swal.fire({
                    title: 'Êtes-vous sûr ?',
                    text: `Vous êtes sur le point de supprimer le vol "${flightNumber}"`,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Oui, supprimer',
                    cancelButtonText: 'Annuler',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        // Show loading state
                        Swal.fire({
                            title: 'Suppression en cours...',
                            html: 'Veuillez patienter...',
                            allowOutsideClick: false,
                            willOpen: () => {
                                Swal.showLoading();
                            },
                        });

                        // Send delete request
                        $.ajax({
                            url: `/manager/flights/${flightId}/delete`,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        title: response.message || 'Supprimé !',
                                        text: response.details || 'Le vol a été supprimé avec succès.',
                                        type: 'success',
                                        showConfirmButton: false,
                                        timer: 1500
                                    }).then(() => {
                                        if (response.redirect) {
                                            window.location.href = response.redirect;
                                        } else {
                                            window.location.reload();
                                        }
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Attention !',
                                        text: response.message || 'Impossible de supprimer ce vol.',
                                        type: 'warning',
                                        confirmButtonText: 'OK'
                                    });
                                }
                            },
                            error: function(xhr) {
                                const response = xhr.responseJSON || {};
                                Swal.fire({
                                    title: 'Erreur !',
                                    text: response.message || 'Une erreur est survenue lors de la suppression.',
                                    type: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush