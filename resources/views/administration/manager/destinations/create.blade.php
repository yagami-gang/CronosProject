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
                        <div class="row g-4">
                            <!-- Colonne 1 -->
                            <div class="col-md-4">
                                <!-- Ville Field -->
                                <div class="form-group mb-4">
                                    <label for="ville" class="form-label fw-bold">Ville <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-primary text-white"><i class="mdi mdi-city"></i></span>
                                        <select class="form-control select2 @error('ville') is-invalid @enderror" 
                                                id="ville" name="ville" required>
                                            <option value="">Sélectionnez une ville</option>
                                            <option value="Yaoundé" {{ old('ville') == 'Yaoundé' ? 'selected' : '' }}>Yaoundé</option>
                                            <option value="Douala" {{ old('ville') == 'Douala' ? 'selected' : '' }}>Douala</option>
                                            <option value="Garoua" {{ old('ville') == 'Garoua' ? 'selected' : '' }}>Garoua</option>
                                            <option value="Bamenda" {{ old('ville') == 'Bamenda' ? 'selected' : '' }}>Bamenda</option>
                                            <option value="Maroua" {{ old('ville') == 'Maroua' ? 'selected' : '' }}>Maroua</option>
                                            <option value="Bafoussam" {{ old('ville') == 'Bafoussam' ? 'selected' : '' }}>Bafoussam</option>
                                            <option value="Ngaoundéré" {{ old('ville') == 'Ngaoundéré' ? 'selected' : '' }}>Ngaoundéré</option>
                                            <option value="Bertoua" {{ old('ville') == 'Bertoua' ? 'selected' : '' }}>Bertoua</option>
                                            <option value="Loum" {{ old('ville') == 'Loum' ? 'selected' : '' }}>Loum</option>
                                            <option value="Kumba" {{ old('ville') == 'Kumba' ? 'selected' : '' }}>Kumba</option>
                                            <option value="Edéa" {{ old('ville') == 'Edéa' ? 'selected' : '' }}>Edéa</option>
                                            <option value="Kousséri" {{ old('ville') == 'Kousséri' ? 'selected' : '' }}>Kousséri</option>
                                            <option value="Foumban" {{ old('ville') == 'Foumban' ? 'selected' : '' }}>Foumban</option>
                                            <option value="Mbouda" {{ old('ville') == 'Mbouda' ? 'selected' : '' }}>Mbouda</option>
                                            <option value="Dschang" {{ old('ville') == 'Dschang' ? 'selected' : '' }}>Dschang</option>
                                            <option value="Limbé" {{ old('ville') == 'Limbé' ? 'selected' : '' }}>Limbé</option>
                                            <option value="Ebolowa" {{ old('ville') == 'Ebolowa' ? 'selected' : '' }}>Ebolowa</option>
                                            <option value="Kribi" {{ old('ville') == 'Kribi' ? 'selected' : '' }}>Kribi</option>
                                            <option value="Buea" {{ old('ville') == 'Buea' ? 'selected' : '' }}>Buea</option>
                                            <option value="Sangmélima" {{ old('ville') == 'Sangmélima' ? 'selected' : '' }}>Sangmélima</option>
                                            <option value="Foumbot" {{ old('ville') == 'Foumbot' ? 'selected' : '' }}>Foumbot</option>
                                            <option value="Bafang" {{ old('ville') == 'Bafang' ? 'selected' : '' }}>Bafang</option>
                                        </select>
                                        @error('ville')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Pays Field -->
                                <div class="form-group mb-4">
                                    <label for="pays" class="form-label fw-bold">Pays <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-primary text-white"><i class="fas fa-globe"></i></span>
                                        <select class="form-select select2 @error('pays') is-invalid @enderror" 
                                                id="pays" name="pays" required>
                                            <option value="">Sélectionnez un pays</option>
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

                            <!-- Colonne 2 -->
                            <div class="col-md-4">
                                <!-- Description Field -->
                                <div class="form-group mb-4">
                                    <label for="description" class="form-label fw-bold">Description <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                            id="description" name="description" rows="8" required 
                                            placeholder="Décrivez brièvement la destination...">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Image Field -->
                                <div class="form-group mb-4">
                                    <label for="image_url" class="form-label fw-bold">Image de la destination <span class="text-danger">*</span></label>
                                    <input type="file" class="dropify" id="image_url" name="image_url" 
                                        data-allowed-file-extensions="jpg jpeg png"
                                        data-max-file-size="2M"
                                        data-height="180" 
                                        @if(old('image_url')) data-default-file="{{ old('image_url') }}" @endif
                                        required />
                                    @error('image_url')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted d-block mt-2">
                                        Format accepté : JPG, JPEG, PNG. Taille max : 2MB
                                    </small>
                                </div>
                            </div>

                            <!-- Colonne 3 -->
                            <div class="col-md-4">
                                <!-- Statut Field -->
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

                                <!-- Populaire Field -->
                                <div class="form-group mb-4">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="populaire" name="populaire" 
                                            value="1" {{ old('populaire') ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold" for="populaire">
                                            <i class="fas fa-star text-warning me-1"></i> Destination populaire
                                        </label>
                                    </div>
                                    @error('populaire')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Note Field -->
                                <div class="form-group mb-4">
                                    <label for="note" class="form-label fw-bold">Note (sur 5)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-primary text-white"><i class="fas fa-star"></i></span>
                                        <input type="number" step="0.1" min="0" max="5" 
                                            class="form-control @error('note') is-invalid @enderror" 
                                            id="note" name="note" value="{{ old('note', 0) }}" 
                                            placeholder="Ex: 4.5">
                                        @error('note')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Boutons de soumission -->
                            <div class="col-12 mt-2 text-center">
                                <div class="d-inline-block">
                                    <a href="{{ route('manager.destinations.index') }}" class="btn btn-danger px-4 me-3 rounded-pill shadow-sm hover-lift">
                                        <i class="fas fa-times me-1"></i> Annuler
                                    </a>
                                    <button type="submit" class="btn btn-success px-4 rounded-pill shadow-sm hover-lift">
                                        <i class="fas fa-save me-1"></i> Enregistrer
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