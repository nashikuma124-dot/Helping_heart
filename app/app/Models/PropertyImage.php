<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyImage extends Model
{
    protected $table = 'property_images';

    public $timestamps = false;

    protected $fillable = [
        'property_id',
        'path',
        'sort_order',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
