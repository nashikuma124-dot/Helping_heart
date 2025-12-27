<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    public function cities()
    {
        return $this->belongsToMany(City::class, 'property_city');
    }

    public function businessTypes()
    {
        return $this->belongsToMany(BusinessType::class, 'property_business_types');
    }

    public function genders()
    {
        return $this->belongsToMany(Gender::class, 'property_gender');
    }

    public function buildingTypes()
    {
        return $this->belongsToMany(BuildingType::class, 'property_building_type');
    }

    public function features()
    {
        return $this->belongsToMany(Feature::class, 'property_features');
    }

    public function images()
    {
        return $this->hasMany(PropertyImage::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
}
