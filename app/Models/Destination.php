<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Destination extends Model
{
    protected $fillable = [
        'pays',
        'ville',
        'description',
        'image_url',
        'statut',
        'populaire',
        'note'
    ];

    protected $casts = [
        'populaire' => 'boolean',
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