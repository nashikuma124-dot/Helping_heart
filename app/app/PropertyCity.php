<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyCity extends Model
{
    protected $table = 'property_city';

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
