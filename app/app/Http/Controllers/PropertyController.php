<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\City;
use App\Models\Property;
use App\Models\BusinessType;
use App\Models\Gender;
use App\Models\BuildingType;
use App\Models\Feature;
use App\Models\LevelDisability;
use App\Models\Amount;


class PropertyController extends Controller
{
    public function search(Request $request)
{
    $businessTypes = BusinessType::orderBy('sort_order')->get();
    $genders       = Gender::orderBy('sort_order')->get();
    $buildingTypes = BuildingType::orderBy('sort_order')->get();
    $features      = Feature::orderBy('sort_order')->get();
    $areas         = Area::orderBy('sort_order')->get();
    $levels        = LevelDisability::orderBy('sort_order')->get();
    $amounts       = Amount::orderBy('sort_order')->get();

    return view('property.search', compact(
        'businessTypes',
        'genders',
        'buildingTypes',
        'features',
        'areas',
        'levels',
        'amounts'
    ));
}

    public function result(Request $request)
{
    // ✅ get() は絶対に呼ばない（最後は paginate のみ）
    $q = Property::query();

    // ----------------------------
    // 1) 空室のみ（availability=1）
    // ----------------------------
    if ((string)$request->input('vacant_only') === '1') {
        $q->where('availability', 1);
    }

    // ----------------------------
    // 2) 都道府県（areas）→ city 経由で絞り込み
    //    ※ properties と city は property_city の多対多想定
    // ----------------------------
    if ($request->filled('area_id')) {
        $areaId = (int)$request->input('area_id');
        $q->whereHas('cities', function ($qq) use ($areaId) {
            $qq->where('area_id', $areaId);
        });
    }

    // ----------------------------
    // 3) 市区町村（複数） city_ids[]
    // ----------------------------
    $cityIds = array_values(array_filter(array_map('intval', (array)$request->input('city_ids', []))));
    if (!empty($cityIds)) {
        $q->whereHas('cities', function ($qq) use ($cityIds) {
            $qq->whereIn('city.id', $cityIds); // city テーブル名が city の場合
            // もしテーブル名が cities なら → $qq->whereIn('cities.id', $cityIds);
        });
    }

    // ----------------------------
    // 4) 事業種類（business[]）※ pivot名はあなたのModelに合わせる
    // Property.php: businessTypes() -> belongsToMany(BusinessType::class, 'property_business_types');
    // ----------------------------
    $businessIds = array_values(array_filter(array_map('intval', (array)$request->input('business', []))));
    if (!empty($businessIds)) {
        $q->whereHas('businessTypes', function ($qq) use ($businessIds) {
            // business_types テーブルが想定、id で絞る
            $qq->whereIn('business_types.id', $businessIds);
        });
    }

    // ----------------------------
    // 5) 受入性別（gender[]）※ pivot名はあなたのModelに合わせる
    // Property.php: genders() -> belongsToMany(Gender::class, 'property_gender');
    // ----------------------------
    $genderIds = array_values(array_filter(array_map('intval', (array)$request->input('gender', []))));
    if (!empty($genderIds)) {
        $q->whereHas('genders', function ($qq) use ($genderIds) {
            $qq->whereIn('genders.id', $genderIds);
        });
    }

    // ----------------------------
    // 6) 建物タイプ（building[]）
    // Property.php: buildingTypes() -> belongsToMany(BuildingType::class, 'property_building_type');
    // ----------------------------
    $buildingIds = array_values(array_filter(array_map('intval', (array)$request->input('building', []))));
    if (!empty($buildingIds)) {
        $q->whereHas('buildingTypes', function ($qq) use ($buildingIds) {
            $qq->whereIn('building_types.id', $buildingIds);
        });
    }

    // ----------------------------
    // 7) 特徴（feature[]）
    // Property.php: features() -> belongsToMany(Feature::class, 'property_features');
    // ----------------------------
    $featureIds = array_values(array_filter(array_map('intval', (array)$request->input('feature', []))));
    if (!empty($featureIds)) {
        $q->whereHas('features', function ($qq) use ($featureIds) {
            $qq->whereIn('features.id', $featureIds);
        });
    }

    // ----------------------------
    // 8) 障がい者区分（単一） properties.level_disability_id
    // ----------------------------
    if ($request->filled('disability_level')) {
        $levelId = (int)$request->input('disability_level');
        $q->where('level_disability_id', $levelId);
    }

    // ----------------------------
    // 9) 家賃（範囲） rent_min / rent_max（properties.rent を想定）
    // ----------------------------
    if ($request->filled('rent_min')) {
        $q->where('rent', '>=', (int)$request->input('rent_min'));
    }
    if ($request->filled('rent_max')) {
        $q->where('rent', '<=', (int)$request->input('rent_max'));
    }

    // ----------------------------
    // 10) フリーワード（title / address / businessname / description）
    // ----------------------------
    if ($request->filled('q')) {
        $word = trim((string)$request->input('q'));
        $q->where(function ($qq) use ($word) {
            $qq->where('title', 'like', "%{$word}%")
               ->orWhere('address', 'like', "%{$word}%")
               ->orWhere('businessname', 'like', "%{$word}%")
               ->orWhere('description', 'like', "%{$word}%");
        });
    }

    // ----------------------------
    // 11) N+1対策：一覧で使いそうな関連を eager load（必要なら調整）
    // ----------------------------
    $q->with(['cities', 'images']);

    // ----------------------------
    // ✅ ここが超重要：最後は paginate のみ。get() は絶対しない。
    // ✅ withQueryString を使わず、Laravelの差を吸収
    // ----------------------------
    $properties = $q->latest()->paginate(10);
    $properties->appends($request->query());

    return view('property.result', compact('properties'));
}

}
