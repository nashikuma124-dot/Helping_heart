<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusinessType extends Model
{
    public function properties()
    {
        return $this->belongsToMany(Property::class, 'property_business_types');
    }
}
