<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'dob',      // or dateofbirth のどちらか（DB列名に合わせる）
        'line_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * ✅ お気に入りした物件（favoritesテーブル経由）
     */
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
