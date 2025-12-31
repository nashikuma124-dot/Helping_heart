<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuildingType extends Model
{
    protected $table = 'building_types';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'sort_order',
    ];
}
