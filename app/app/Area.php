<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
