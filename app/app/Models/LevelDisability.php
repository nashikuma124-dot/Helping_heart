<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LevelDisability extends Model
{
    public $timestamps = false;

    protected $table = 'level_disability'; // テーブル名がこれ

    protected $fillable = [
        'name',
        'sort_order',
    ];
}
