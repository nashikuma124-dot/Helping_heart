<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyGender extends Model
{
    protected $table = 'property_gender';

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }
}
