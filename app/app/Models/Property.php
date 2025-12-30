<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// ★ ここが重要（relationで使うModelをすべてuse）
use App\Models\City;
use App\Models\BusinessType;
use App\Models\Gender;
use App\Models\BuildingType;
use App\Models\Feature;
use App\Models\PropertyImage;
use App\Models\Favorite;

class Property extends Model
{
    protected $table = 'properties'; // ← テーブル名が違うなら修正

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // 市区町村
    public function cities()
    {
        return $this->belongsToMany(City::class, 'property_city');
    }

    // 事業種別
    public function businessTypes()
    {
        return $this->belongsToMany(BusinessType::class, 'property_business_types');
    }

    // 受入性別
    public function genders()
    {
        return $this->belongsToMany(Gender::class, 'property_gender');
    }

    // 建物タイプ
    public function buildingTypes()
    {
        return $this->belongsToMany(BuildingType::class, 'property_building_type');
    }

    // 特徴
    public function features()
    {
        return $this->belongsToMany(Feature::class, 'property_features');
    }

    // 画像
    public function images()
    {
        return $this->hasMany(PropertyImage::class);
    }

    // お気に入り
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
}
