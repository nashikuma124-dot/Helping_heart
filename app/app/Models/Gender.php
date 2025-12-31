<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    protected $table = 'gender';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'sort_order',
    ];
}
