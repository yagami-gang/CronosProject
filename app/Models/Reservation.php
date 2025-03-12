<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'flight_id',
        'status',
        'seat_number',
        'price_paid',
        'payment_status'
    ];

    protected $casts = [
        'price_paid' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function flight()
    {
        return $this->belongsTo(Flight::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
