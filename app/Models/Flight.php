<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Flight extends Model
{
    use HasFactory;

    protected $fillable = [
        'flight_number',
        'ville_depart_id',
        'destination_id',
        'departure_time',
        'arrival_time',
        'price',
        'total_seats',
        'available_seats',
        'status',
        'duree_sejour',
        'date_depart',
        'prix_a_partir_de',
        'note'
    ];

    protected $casts = [
        'departure_time' => 'datetime',
        'arrival_time' => 'datetime',
        'price' => 'decimal:2',
        'date_depart' => 'date',
        'prix_a_partir_de' => 'decimal:2',
        'note' => 'decimal:1'
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }
    public function isAvailable()
    {
        return $this->available_seats > 0 && $this->status === 'active';
    }
}
