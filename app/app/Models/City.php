<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public $timestamps = false;

    protected $table = 'city';

    protected $fillable = [
        'area_id',
        'name',
        'sort_order',
    ];

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }
}
