<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyBuildingType extends Model
{
    protected $table = 'property_building_type';

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function buildingType()
    {
        return $this->belongsTo(BuildingType::class);
    }
}
