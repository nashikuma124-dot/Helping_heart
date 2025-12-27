<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyBusinessType extends Model
{
    protected $table = 'property_business_types';

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function businessType()
    {
        return $this->belongsTo(BusinessType::class);
    }
}
