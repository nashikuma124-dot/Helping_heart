<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyImage extends Model
{
    protected $table = 'property_images';

    // 画像テーブルは created_at / updated_at がある前提（無いなら false にしてください）
    public $timestamps = true;

    protected $fillable = [
        'property_id',
        'image_path',
        'sort_order',
    ];

    // 物件（properties）
    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id');
    }
}
