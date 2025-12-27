<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BuildingType extends Model
{
    public function properties()
    {
        return $this->belongsToMany(Property::class, 'property_building_type');
    }
}
