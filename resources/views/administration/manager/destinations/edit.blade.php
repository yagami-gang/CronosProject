@extends('administration.layouts.app')

@section('title', 'Modifier une destination')

@push('styles')
<link href="{{ asset('assets/libs/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/libs/dropify/dist/css/dropify.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 align-self-center">
            <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Modifier une destination</h3>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('manager.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('manager.destinations.index') }}">Destinations</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Modifier la destination</li>
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
                    <form action="{{ route('manager.destinations.update', $destination) }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <label for="ville" class="form-label fw-bold">Ville <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-primary text-white"><i class="mdi mdi-city"></i></span>
                                                <select class="form-select select2 @error('ville') is-invalid @enderror" 
                                                        id="ville" name="ville" required>
                                                    <option value="">Sélectionner une ville</option>
                                                    @php
                                                        $cameroonCities = [
                                                            'Douala', 'Yaoundé', 'Garoua', 'Bamenda', 'Bafoussam',
                                                            'Ngaoundéré', 'Maroua', 'Kousséri', 'Buéa', 'Ebolowa',
                                                            'Bafang', 'Foumban', 'Édéa', 'Kribi', 'Dschang',
                                                            'Nkongsamba', 'Limbé', 'Kumba', 'Meiganga', 'Bafut',
                                                            'Tiko', 'Kumbo', 'Mokolo', 'Bertoua', 'Mbalmayo',
                                                            'Loum', 'Nkoteng', 'Yagoua', 'Mora', 'Sangmélima',
                                                            'Batouri', 'Mbouda', 'Foumbot', 'Bangangté', 'Tibati',
                                                            'Melong', 'Manjo', 'Mbandjock', 'Tombel', 'Banyo',
                                                            'Nanga Eboko', 'Bogo', 'Akonolinga', 'Eséka', 'Mamfé',
                                                            'Obala', 'Muyuka', 'Ngaoundal', 'Abong-Mbang', 'Fundong',
                                                            'Nkambe', 'Fontem', 'Tignère', 'Akono', 'Yokadouma',
                                                            'Tonga', 'Mbankomo', 'Bana', 'Bétaré-Oya', 'Bélabo',
                                                            'Tibati', 'Mbanga', 'Bafang', 'Bali', 'Bazou',
                                                            'Bekondo', 'Bélabo', 'Bélabo', 'Bétaré-Oya', 'Bibémi',
                                                            'Bipindi', 'Bogo', 'Bokito', 'Bondjock', 'Bot-Makak',
                                                            'Bourrha', 'Dibombari', 'Dizangué', 'Djohong', 'Doumaintang',
                                                            'Dzeng', 'Évodoula', 'Figuil', 'Fontem', 'Garoua-Boulaï',
                                                            'Gobo', 'Guider', 'Kaélé', 'Kontcha', 'Lagdo', 'Maga',
                                                            'Makary', 'Mbe', 'Mbe', 'Méri', 'Mindif', 'Mintom', 'Moulvoudaye',
                                                            'Moutourwa', 'Mundemba', 'Mutengene', 'Nanga-Eboko', 'Ndikiniméki',
                                                            'Ndom', 'Ngambe', 'Ngomedzap', 'Ngou', 'Ngoro', 'Nguelebok',
                                                            'Nkondjock', 'Nlonako', 'Ntui', 'Nyanon', 'Okola', 'Ombesa',
                                                            'Ombésa', 'Pitoa', 'Pol', 'Tchati-Bali', 'Tibati', 'Tignère',
                                                            'Tiko', 'Tombel', 'Touboro', 'Touho', 'Touloum', 'Yabassi', 'Yagoua',
                                                            'Yakade', 'Yamba', 'Yambeta', 'Yambuya', 'Yanléos', 'Yassa', 'Yatou',
                                                            'Yingui', 'Yokadouma', 'Yokosé', 'Yokoté', 'Yong', 'Yongwe', 'Yoro',
                                                            'Zina', 'Zouaye', 'Zouila', 'Zoulabot', 'Zouméa', 'Zouméa II', 'Zouméa III',
                                                            'Zouméa IV', 'Zouméa V', 'Zouméa VI', 'Zouméa VII', 'Zouméa VIII', 'Zouméa IX', 'Zouméa X'
                                                        ];
                                                        sort($cameroonCities);
                                                    @endphp
                                                    @foreach($cameroonCities as $city)
                                                        <option value="{{ $city }}" {{ old('ville', $destination->ville) == $city ? 'selected' : '' }}>
                                                            {{ $city }}
                                                        </option>
                                                    @endforeach
                                                </select>
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
                                                <select class="form-select @error('pays') is-invalid @enderror" 
                                                        id="pays" name="pays" required>
                                                    <option value="">Sélectionner un pays</option>
                                                    @foreach($pays as $code => $nom)
                                                        <option value="{{ $code }}" {{ old('pays', $destination->pays) == $code ? 'selected' : '' }}>
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
                                    <div class="col-12 mb-4">
                                        <div class="form-group">
                                            <label for="description" class="form-label fw-bold">Description de la destination <span class="text-danger">*</span></label>
                                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                                    id="description" name="description" rows="4" required 
                                                    placeholder="Décrivez brièvement la destination...">{{ old('description', $destination->description) }}</textarea>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <label for="note" class="form-label fw-bold">Note (0-5)</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-primary text-white"><i class="fas fa-star"></i></span>
                                                <input type="number" class="form-control @error('note') is-invalid @enderror" 
                                                       id="note" name="note" value="{{ old('note', $destination->note) }}" 
                                                       min="0" max="5" step="0.1" placeholder="Ex: 4.5">
                                                @error('note')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <small class="text-muted">Note sur 5 (optionnel)</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <label class="form-label fw-bold">Options</label>
                                            <div class="form-check form-switch mt-2">
                                                <input class="form-check-input" type="checkbox" id="populaire" name="populaire" 
                                                       value="1" {{ old('populaire', $destination->populaire) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="populaire">Mettre en avant</label>
                                                <small class="d-block text-muted">Afficher cette destination en page d'accueil</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-4">
                                    <label for="image_url" class="form-label fw-bold">Image de la destination <span class="text-danger">*</span></label>
                                    <input type="file" class="dropify @error('image_url') is-invalid @enderror" 
                                           id="image_url" name="image_url" 
                                           data-allowed-file-extensions="jpg jpeg png"
                                           data-max-file-size="2M"
                                           data-height="200"
                                           data-default-file="{{ $destination->image_url ? asset('storage/' . $destination->image_url) : '' }}" />
                                    @error('image_url')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted d-block mt-2">
                                        Format accepté : JPG, JPEG, PNG. Taille max : 2MB.
                                    </small>
                                </div>
                                <div class="form-group mb-4">
                                    <label for="statut" class="form-label fw-bold">Statut <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-primary text-white"><i class="fas fa-toggle-on"></i></span>
                                        <select class="form-select @error('statut') is-invalid @enderror" 
                                                id="statut" name="statut" required>
                                            <option value="actif" {{ old('statut', $destination->statut) == 'actif' ? 'selected' : '' }}>Actif</option>
                                            <option value="inactif" {{ old('statut', $destination->statut) == 'inactif' ? 'selected' : '' }}>Inactif</option>
                                        </select>
                                        @error('statut')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-4 text-center">
                                <div class="d-inline-block">
                                    <a href="{{ route('manager.destinations.index') }}" class="btn btn-danger px-4 me-3 rounded-pill shadow-sm hover-lift">
                                        <i class="fas fa-times me-1"></i> Annuler
                                    </a>
                                    <button type="submit" class="btn btn-success px-4 rounded-pill shadow-sm hover-lift">
                                        <i class="fas fa-save me-1"></i> Mettre à jour la destination
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
    // Initialisation de Select2 pour le champ de ville
    $('#ville').select2({
        placeholder: 'Rechercher une ville...',
        allowClear: true,
        width: '100%'
    });

    // Initialisation de Dropify pour le téléchargement d'images
    $('.dropify').dropify({
        messages: {
            default: 'Glissez-déposez un fichier ici ou cliquez',
            replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
            remove: 'Supprimer',
            error: 'Désolé, une erreur est survenue',
            fileSize: 'La taille du fichier est trop grande (2M max).'
        },
        error: {
            'fileSize': 'La taille du fichier est trop grande (2M max).',
            'imageFormat': 'Le format du fichier n\'est pas autorisé ({{ config("upload.image_extensions") }}).'
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
    }, false);
});
</script>
@endpush