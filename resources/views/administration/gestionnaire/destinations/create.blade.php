@extends('administration.layouts.app')

@section('title', 'Ajouter une destination')

@push('styles')
<link href="{{ asset('assets/libs/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/libs/dropify/dist/css/dropify.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 align-self-center">
            <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Ajouter une destination</h3>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('manager.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('manager.destinations.index') }}">Destinations</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Nouvelle destination</li>
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
                    <form action="{{ route('manager.destinations.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <label for="ville" class="form-label fw-bold">Ville <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-primary text-white"><i class="mdi mdi-city"></i></span>
                                                <input type="text" class="form-control @error('ville') is-invalid @enderror" 
                                                       id="ville" name="ville" value="{{ old('ville') }}" 
                                                       placeholder="Entrez le nom de la ville" required>
                                                @error('ville')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <label for="pays" class="form-label fw-bold">Pays <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-primary text-white"><i class="fas fa-globe"></i></span>
                                                <select class="form-select select2 @error('pays') is-invalid @enderror" 
                                                        id="pays" name="pays" required>
                                                    <option value="">Sélectionner un pays</option>
                                                    @foreach($pays as $code => $nom)
                                                        <option value="{{ $code }}" {{ old('pays') == $code ? 'selected' : '' }}>
                                                            {{ $nom }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('pays')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <label for="code_aeroport" class="form-label fw-bold">Code aéroport <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-primary text-white"><i class="mdi mdi-airplane"></i></span>
                                                <input type="text" class="form-control @error('code_aeroport') is-invalid @enderror" 
                                                       id="code_aeroport" name="code_aeroport" value="{{ old('code_aeroport') }}" 
                                                       placeholder="Ex: CDG, JFK, DLA" required maxlength="5" style="text-transform: uppercase;">
                                                @error('code_aeroport')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <small class="text-muted">Code IATA de l'aéroport (3 lettres)</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <label for="timezone" class="form-label fw-bold">Fuseau horaire <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-primary text-white"><i class="fas fa-clock"></i></span>
                                                <select class="form-select select2 @error('timezone') is-invalid @enderror" 
                                                        id="timezone" name="timezone" required>
                                                    <option value="">Sélectionner un fuseau horaire</option>
                                                    @foreach($timezones as $tz)
                                                        <option value="{{ $tz }}" {{ old('timezone') == $tz ? 'selected' : '' }}>
                                                            {{ $tz }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('timezone')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-4">
                                        <div class="form-group">
                                            <label for="description" class="form-label fw-bold">Description de la destination <span class="text-danger">*</span></label>
                                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                                    id="description" name="description" rows="4" required 
                                                    placeholder="Décrivez brièvement la destination...">{{ old('description') }}</textarea>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-4">
                                    <label for="image" class="form-label fw-bold">Image de la destination <span class="text-danger">*</span></label>
                                    <input type="file" class="dropify" id="image" name="image_url" 
                                           data-allowed-file-extensions="jpg jpeg png"
                                           data-max-file-size="2M"
                                           data-height="200" />
                                    @error('image_url')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted d-block mt-2">
                                        Format accepté : JPG, JPEG, PNG. Taille max : 2MB
                                    </small>
                                </div>
                                <div class="form-group mb-4">
                                    <label for="statut" class="form-label fw-bold">Statut <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-primary text-white"><i class="fas fa-toggle-on"></i></span>
                                        <select class="form-select @error('statut') is-invalid @enderror" 
                                                id="statut" name="statut" required>
                                            <option value="actif" {{ old('statut') == 'actif' ? 'selected' : '' }}>Actif</option>
                                            <option value="inactif" {{ old('statut') == 'inactif' ? 'selected' : '' }}>Inactif</option>
                                        </select>
                                        @error('statut')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- Ajouter ces champs avant la div col-12 mt-4 text-center -->
                            <div class="col-md-6 mb-4">
                                <div class="form-group">
                                    <label for="duree_sejour" class="form-label fw-bold">Durée du séjour</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-primary text-white"><i class="fas fa-clock"></i></span>
                                        <input type="text" class="form-control @error('duree_sejour') is-invalid @enderror" 
                                               id="duree_sejour" name="duree_sejour" value="{{ old('duree_sejour') }}" 
                                               placeholder="Ex: 7 jours / 6 nuits">
                                        @error('duree_sejour')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-4">
                                <div class="form-group">
                                    <label for="date_depart" class="form-label fw-bold">Date de départ</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-primary text-white"><i class="fas fa-calendar-alt"></i></span>
                                        <input type="date" class="form-control @error('date_depart') is-invalid @enderror" 
                                               id="date_depart" name="date_depart" value="{{ old('date_depart') }}">
                                        @error('date_depart')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-4">
                                <div class="form-group">
                                    <label for="prix_a_partir_de" class="form-label fw-bold">Prix à partir de</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-primary text-white"><i class="fas fa-euro-sign"></i></span>
                                        <input type="number" step="0.01" class="form-control @error('prix_a_partir_de') is-invalid @enderror" 
                                               id="prix_a_partir_de" name="prix_a_partir_de" value="{{ old('prix_a_partir_de') }}" 
                                               placeholder="Ex: 899.99">
                                        @error('prix_a_partir_de')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-4">
                                <div class="form-group">
                                    <label for="note" class="form-label fw-bold">Note (sur 5)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-primary text-white"><i class="fas fa-star"></i></span>
                                        <input type="number" step="0.1" min="0" max="5" class="form-control @error('note') is-invalid @enderror" 
                                               id="note" name="note" value="{{ old('note') }}" 
                                               placeholder="Ex: 4.5">
                                        @error('note')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-4">
                                <div class="form-group">
                                    <label for="populaire" class="form-label fw-bold">Destination populaire</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="populaire" name="populaire" value="1" {{ old('populaire') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="populaire">Marquer comme populaire</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-4 text-center">
                                <div class="d-inline-block">
                                    <a href="{{ route('manager.destinations.index') }}" class="btn btn-danger px-4 me-3 rounded-pill shadow-sm hover-lift">
                                        <i class="fas fa-times me-1"></i> Annuler
                                    </a>
                                    <button type="submit" class="btn btn-success px-4 rounded-pill shadow-sm hover-lift">
                                        <i class="fas fa-save me-1"></i> Enregistrer la destination
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/libs/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/libs/dropify/dist/js/dropify.min.js') }}"></script>
<script>
$(document).ready(function() {
    // Initialisation de Select2
    $('.select2').select2();

    // Initialisation de Dropify
    $('.dropify').dropify({
        messages: {
            default: 'Glissez-déposez un fichier ici ou cliquez',
            replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
            remove: 'Supprimer',
            error: 'Désolé, une erreur est survenue'
        }
    });

    // Validation du formulaire
    const form = document.querySelector('.needs-validation');
    form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.classList.add('was-validated');
    });
});
</script>
@endpush