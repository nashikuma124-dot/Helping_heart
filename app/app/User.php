<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    const ROLE_ADMIN = 'admin';
    const ROLE_USER  = 'user';

    protected $fillable = [
        'name',
        'email',
        'password',
        'line_id',
        'line_access_token',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /* relations */

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function inquiries()
    {
        return $this->hasMany(Inquiry::class);
    }

    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }

    /* helpers */

    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }
}
