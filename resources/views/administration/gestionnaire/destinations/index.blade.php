@extends('administration.layouts.app')

@section('title', 'Gestion des Destinations')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 align-self-center">
            <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Destinations</h3>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('manager.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Destinations</li>
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
                        <h4 class="card-title">Liste des destinations</h4>
                        <a href="{{ route('manager.destinations.create') }}" class="btn btn-primary rounded-pill">
                            <i class="fas fa-plus-circle mr-1"></i> Nouvelle destination
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table id="destinations-table" class="table table-striped table-bordered no-wrap">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Ville</th>
                                    <th>Pays</th>
                                    <th>Code Aéroport</th>
                                    <th>Statut</th>
                                    <th>Vols</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($destinations as $destination)
                                    <tr>
                                        <td class="align-middle">
                                            <img src="{{ $destination->getImageUrlComplete() }}" 
                                                 alt="{{ $destination->ville }}" 
                                                 class="rounded-circle"
                                                 width="40" height="40">
                                        </td>
                                        <td class="align-middle">{{ $destination->ville }}</td>
                                        <td class="align-middle">{{ $destination->pays }}</td>
                                        <td class="align-middle">{{ $destination->code_aeroport }}</td>
                                        <td class="align-middle">
                                            <span class="badge badge-pill badge-{{ $destination->statut === 'actif' ? 'success' : 'danger' }} rounded-pill">
                                                {{ ucfirst($destination->statut) }}
                                            </span>
                                        </td>
                                        <td class="align-middle">
                                            <span class="badge badge-pill badge-info">
                                                {{ $destination->vols_count ?? 0 }} vols
                                            </span>
                                        </td>
                                        <td class="align-middle">
                                            <div class="dropdown">
                                                <button class="btn btn-link text-dark dropdown-toggle" type="button" id="dropdownMenuButton{{ $destination->id }}" data-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton{{ $destination->id }}">
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('manager.destinations.edit', $destination) }}">
                                                            <i class="fas fa-edit text-info me-2"></i> Modifier
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <button class="dropdown-item text-danger delete-destination" 
                                                                data-id="{{ $destination->id }}"
                                                                data-ville="{{ $destination->ville }}">
                                                            <i class="fas fa-trash-alt me-2"></i> Supprimer
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <div class="d-flex flex-column align-items-center">
                                                <i class="fas fa-map-marked-alt fa-3x text-muted mb-3"></i>
                                                <h5 class="text-muted">Aucune destination trouvée</h5>
                                                <a href="{{ route('manager.destinations.create') }}" class="btn btn-primary mt-3">
                                                    <i class="fas fa-plus-circle mr-1"></i> Ajouter une destination
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $destinations->links() }}
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
            // Existing DataTable initialization...

            // Delete destination handling
            $('.delete-destination').on('click', function() {
                const destinationId = $(this).data('id');
                const destinationVille = $(this).data('ville');

                Swal.fire({
                    title: 'Êtes-vous sûr ?',
                    text: `Vous êtes sur le point de supprimer la destination "${destinationVille}"`,
                    type: "warning",
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
                            url: `/manager/destinations/${destinationId}/delete `,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        title: response.message || 'Supprimé !',
                                        text: response.details || 'La destination a été supprimée avec succès.',
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
                                        text: response.message || 'Impossible de supprimer cette destination.',
                                        icon: 'warning',
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