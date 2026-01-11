<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'dateofbirth',
        'line_id',
    ];

    protected $hidden = [
        'password',
        // DBに無いなら入れない
        // 'remember_token',
    ];

    protected $casts = [
        'dateofbirth' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | リレーション
    |--------------------------------------------------------------------------
    */

    // お気に入り物件
    public function favoriteProperties()
    {
        return $this->belongsToMany(
            \App\Models\Property::class,
            'favorites',
            'user_id',
            'property_id'
        );
    }
}
