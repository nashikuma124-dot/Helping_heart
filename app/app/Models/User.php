<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        // ここはDBの実カラム名に合わせてください（dateofbirthが無いなら dob に統一）
        'dateofbirth',
        'line_id',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'dateofbirth' => 'date',
        'deleted_at'  => 'datetime',
    ];
}
