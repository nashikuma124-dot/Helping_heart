<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LevelDisability extends Model
{
    protected $table = 'level_disability';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'sort_order',
    ];
}
