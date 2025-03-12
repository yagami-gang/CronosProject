<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Role;
use App\Models\Reservation;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // 'admin', 'manager', 'client'
        'phone',
        'profile_photo'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Check if user has the specified role
     * @param string $role
     * @return bool
     */
    public function hasRole($role)
    {
        return $this->roles()->where('name', $role)->exists();
    }
}
