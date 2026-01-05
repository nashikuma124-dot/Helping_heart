<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $table = 'properties';

    protected $fillable = [
        'title',
        'rent',
        'utilities',
        'foodcosts',
        'supplies',
        'otherexpenses',
        'subtotal',
        'total',
        'capacity',
        'availability',
        'address',

        // ✅ 追加：最寄り駅（DB化したカラム）
        'nearest_station',
        'walk_minutes',

        'businessname',
        'contactaddress',
        'description',
        'status',
        'area_id',
        'level_disability_id',
        'amount_id',

        // ✅ 受入性別（properties.gender_id）
        'gender_id',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    // 都道府県（areas）
    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    // 受入性別（gender テーブル：注意：テーブル名が gender の想定）
    public function gender()
    {
        return $this->belongsTo(Gender::class, 'gender_id');
    }

    // 市区町村（pivot: property_city / cityテーブル名が "city" の想定）
    public function cities()
    {
        return $this->belongsToMany(City::class, 'property_city', 'property_id', 'city_id');
    }

    // 事業種類（pivot: property_business_types）
    public function businessTypes()
    {
        return $this->belongsToMany(
            BusinessType::class,
            'property_business_types',
            'property_id',
            'business_type_id'
        );
    }

    // 建物タイプ（pivot: property_building_type）
    public function buildingTypes()
    {
        return $this->belongsToMany(
            BuildingType::class,
            'property_building_type',
            'property_id',
            'building_type_id'
        );
    }

    // 特徴（pivot: property_features）
    public function features()
    {
        return $this->belongsToMany(
            Feature::class,
            'property_features',
            'property_id',
            'feature_id'
        );
    }

    // 画像（property_images）
    public function images()
    {
        return $this->hasMany(PropertyImage::class, 'property_id');
    }

    // お気に入り（favorites）
    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'property_id');
    }

    // 障がい者区分（level_disability）
    public function levelDisability()
    {
        return $this->belongsTo(LevelDisability::class, 'level_disability_id');
    }

    // 金額（amount）
    public function amount()
    {
        return $this->belongsTo(Amount::class, 'amount_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers (optional)
    |--------------------------------------------------------------------------
    */

    // ✅ 掲載日表示用（created_at を整形）
    public function getPublishedDateAttribute(): string
    {
        return $this->created_at ? $this->created_at->format('Y/m/d') : '';
    }

    // ✅ 最寄り駅表示用（DB値が無い時の保険）
    public function getStationTextAttribute(): string
    {
        $station = $this->nearest_station ?: '—';
        $walk    = $this->walk_minutes !== null ? (int)$this->walk_minutes : null;

        return $walk === null ? "{$station}" : "{$station} 徒歩{$walk}分";
    }
}
