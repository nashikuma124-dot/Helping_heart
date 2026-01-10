<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'dateofbirth', // ✅ 追加
        'line_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
