<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Destination extends Model
{
    protected $fillable = [
        'pays',
        'ville',
        'code_aeroport',
        'description',
        'image_url',
        'statut',
        'fuseau_horaire',
        'populaire',
        'duree_sejour',
        'date_depart',
        'prix_a_partir_de',
        'note'
    ];

    protected $casts = [
        'populaire' => 'boolean',
        'date_depart' => 'date'
    ];

    /**
     * Vérifier si la destination est populaire
     */
    public function estPopulaire(): bool
    {
        return $this->populaire;
    }
    /**
     * Obtenir l'URL complète de l'image
     */
    public function getImageUrlComplete(): string
    {
        return $this->image_url ? asset('storage/' . $this->image_url) : asset('images/default-destination.jpg');
    }
    public function flights(): HasMany
    {
        return $this->hasMany(Flight::class);
    }
}