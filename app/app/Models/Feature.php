<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    protected $table = 'features';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'sort_order',
    ];
}
