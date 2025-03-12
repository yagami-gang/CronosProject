<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Flight extends Model
{
    use HasFactory;

    protected $fillable = [
        'flight_number',
        'departure',
        'destination_id',
        'destination',
        'departure_time',
        'arrival_time',
        'price',
        'total_seats',
        'available_seats',
        'status'
    ];

    protected $casts = [
        'departure_time' => 'datetime',
        'arrival_time' => 'datetime',
        'price' => 'decimal:2'
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
