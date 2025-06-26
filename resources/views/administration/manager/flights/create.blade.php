@extends('administration.layouts.app')

@section('title', 'Ajouter un nouveau vol')

@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 align-self-center">
                <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Ajouter un nouveau vol</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb m-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('manager.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('manager.flights.index') }}">Vols</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Nouveau vol</li>
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
                    <form action="{{ route('manager.flights.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="row">
                            <!-- Flight Information -->
                            <div class="col-md-4 mb-4">
                                <div class="form-group">
                                    <label for="numero_vol" class="form-label fw-bold">Numéro de vol <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-primary text-white"><i class="fas fa-plane"></i></span>
                                        <input type="text" class="form-control @error('numero_vol') is-invalid @enderror" 
                                               id="numero_vol" name="numero_vol" required 
                                               placeholder="Ex: AF123" value="{{ old('numero_vol') }}">
                                        @error('numero_vol')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 mb-4">
                                <div class="form-group">
                                    <label for="ville_depart_id" class="form-label fw-bold">Ville de départ <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-primary text-white"><i class="fas fa-map-marker-alt"></i></span>
                                        <select class="form-select @error('ville_depart_id') is-invalid @enderror" 
                                                id="ville_depart_id" name="ville_depart_id" required>
                                            <option value="">Sélectionner une ville de départ</option>
                                            @foreach($destinations as $destination)
                                                <option value="{{ $destination->id }}" 
                                                        {{ old('ville_depart_id') == $destination->id ? 'selected' : '' }}>
                                                    {{ $destination->ville }}, {{ $destination->pays }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('ville_depart_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 mb-4">
                                <div class="form-group">
                                    <label for="destination_id" class="form-label fw-bold">Destination <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-primary text-white"><i class="fas fa-map-marker-alt"></i></span>
                                        <select class="form-select @error('destination_id') is-invalid @enderror" 
                                                id="destination_id" name="destination_id" required>
                                            <option value="">Sélectionner une destination</option>
                                            @foreach($destinations as $destination)
                                                <option value="{{ $destination->id }}" 
                                                        {{ old('destination_id') == $destination->id ? 'selected' : '' }}>
                                                    {{ $destination->ville }}, {{ $destination->pays }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('destination_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 mb-4">
                                <div class="form-group">
                                    <label for="heure_depart" class="form-label fw-bold">Date et heure de départ <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-primary text-white"><i class="fas fa-calendar-alt"></i></span>
                                        <input type="datetime-local" class="form-control @error('heure_depart') is-invalid @enderror" 
                                               id="heure_depart" name="heure_depart" required 
                                               value="{{ old('heure_depart') }}">
                                        @error('heure_depart')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 mb-4">
                                <div class="form-group">
                                    <label for="heure_arrivee" class="form-label fw-bold">Date et heure d'arrivée <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-primary text-white"><i class="fas fa-calendar-check"></i></span>
                                        <input type="datetime-local" class="form-control @error('heure_arrivee') is-invalid @enderror" 
                                               id="heure_arrivee" name="heure_arrivee" required 
                                               value="{{ old('heure_arrivee') }}">
                                        @error('heure_arrivee')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 mb-4">
                                <div class="form-group">
                                    <label for="prix" class="form-label fw-bold">Prix (FCFA) <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-primary text-white"><i class="fas fa-money-bill-alt"></i></span>
                                        <input type="number" class="form-control @error('prix') is-invalid @enderror" 
                                               id="prix" name="prix" required min="0" step="1000"
                                               value="{{ old('prix') }}">
                                        @error('prix')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <div class="form-group">
                                    <label for="duree_sejour" class="form-label fw-bold">Durée du séjour</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-primary text-white"><i class="fas fa-clock"></i></span>
                                        <input type="text" class="form-control @error('duree_sejour') is-invalid @enderror" 
                                               id="duree_sejour" name="duree_sejour" 
                                               placeholder="Ex: 7 jours / 6 nuits" value="{{ old('duree_sejour') }}">
                                        @error('duree_sejour')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 mb-4">
                                <div class="form-group">
                                    <label for="prix_a_partir_de" class="form-label fw-bold">Prix à partir de (FCFA)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-primary text-white"><i class="fas fa-tag"></i></span>
                                        <input type="number" class="form-control @error('prix_a_partir_de') is-invalid @enderror" 
                                               id="prix_a_partir_de" name="prix_a_partir_de" min="0" step="1000"
                                               value="{{ old('prix_a_partir_de') }}">
                                        @error('prix_a_partir_de')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <small class="text-muted">Prix promotionnel affiché sur la carte</small>
                                </div>
                            </div>

                            <div class="col-md-4 mb-4">
                                <div class="form-group">
                                    <label for="note" class="form-label fw-bold">Note (0-5)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-primary text-white"><i class="fas fa-star"></i></span>
                                        <input type="number" class="form-control @error('note') is-invalid @enderror" 
                                               id="note" name="note" min="0" max="5" step="0.1"
                                               value="{{ old('note') }}">
                                        @error('note')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 mb-4">
                                <div class="form-group">
                                    <label for="capacite" class="form-label fw-bold">Capacité <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-primary text-white"><i class="fas fa-users"></i></span>
                                        <input type="number" class="form-control @error('capacite') is-invalid @enderror" 
                                               id="capacite" name="capacite" required min="1"
                                               value="{{ old('capacite') }}">
                                        @error('capacite')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 mb-4">
                                <div class="form-group">
                                    <label for="statut" class="form-label fw-bold">Statut <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-primary text-white"><i class="fas fa-toggle-on"></i></span>
                                        <select class="form-select @error('statut') is-invalid @enderror" 
                                                id="statut" name="statut" required>
                                            <option value="planifié" {{ old('statut') == 'planifié' ? 'selected' : '' }}>Planifié</option>
                                            <option value="confirmé" {{ old('statut') == 'confirmé' ? 'selected' : '' }}>Confirmé</option>
                                            <option value="annulé" {{ old('statut') == 'annulé' ? 'selected' : '' }}>Annulé</option>
                                        </select>
                                        @error('statut')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="col-12 mt-4 text-center">
                                <div class="d-inline-block">
                                    <a href="{{ route('manager.flights.index') }}" class="btn btn-danger px-4 me-3 rounded-pill shadow-sm hover-lift">
                                        <i class="fas fa-times me-1"></i> Annuler
                                    </a>
                                    <button type="submit" class="btn btn-success px-4 rounded-pill shadow-sm hover-lift">
                                        <i class="fas fa-save me-1"></i> Enregistrer le vol
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
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validation personnalisée pour la date d'arrivée
    const departInput = document.getElementById('heure_depart');
    const arriveeInput = document.getElementById('heure_arrivee');

    function validateDates() {
        if (departInput.value && arriveeInput.value) {
            if (new Date(arriveeInput.value) <= new Date(departInput.value)) {
                arriveeInput.setCustomValidity('La date d\'arrivée doit être postérieure à la date de départ');
            } else {
                arriveeInput.setCustomValidity('');
            }
        }
    }

    departInput.addEventListener('change', validateDates);
    arriveeInput.addEventListener('change', validateDates);

    // Initialisation de la validation du formulaire
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