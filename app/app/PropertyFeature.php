<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyFeature extends Model
{
    protected $table = 'property_features';

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function feature()
    {
        return $this->belongsTo(Feature::class);
    }
}
