<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    public function properties()
    {
        return $this->belongsToMany(Property::class, 'property_gender');
    }
}
