<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Amount extends Model
{
    public function properties()
    {
        return $this->hasMany(Property::class);
    }
}
