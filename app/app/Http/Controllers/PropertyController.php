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
    public function index(Request $request)
    {
        $properties = Property::query()
            ->with(['images', 'area', 'gender'])
            ->latest()
            ->paginate(10);

        return view('property.index', compact('properties'));
    }

    public function show(Property $property)
    {
        $property->load([
            'images' => function ($q) {
                $q->orderBy('sort_order');
            },
            'area',
            'gender',
            'cities',
            'businessTypes',
            'buildingTypes',
            'features',
            'levelDisability',
            'amount',
        ]);

        return view('property.show', compact('property'));
    }

    // 検索画面
    public function search()
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

    // 検索結果（get()混入なし：paginateだけ）
    public function result(Request $request)
    {
        
    // 配列系は先に正規化（空文字混入・型ブレ防止）
        $areaId       = $request->filled('area_id') ? (int)$request->input('area_id') : null;
        $cityIds      = array_values(array_filter(array_map('intval', (array)$request->input('city_ids', []))));
        $businessIds  = array_values(array_filter(array_map('intval', (array)$request->input('business', []))));
        $genderIds    = array_values(array_filter(array_map('intval', (array)$request->input('gender', []))));
        $buildingIds  = array_values(array_filter(array_map('intval', (array)$request->input('building', []))));
        $featureIds   = array_values(array_filter(array_map('intval', (array)$request->input('feature', []))));

            $q = Property::query()->with([
                'images',
                'area',
                'gender',
                'cities',
                'businessTypes',
                'buildingTypes',
                'features',
                'levelDisability',
                'amount',
            ]);

    // 空室のみ
    if ((string)$request->input('vacant_only') === '1') {
        $q->where('availability', 1);
    }

    /**
     * ✅ 重要：都道府県・市区町村の絞り込みは
     * city テーブル名を明示して絞る（ここがバグ原因になりやすい）
     */
    if ($areaId !== null) {
        $q->whereHas('cities', function ($qq) use ($areaId) {
            $qq->where('city.area_id', $areaId);
        });
    }

    if (!empty($cityIds)) {
        $q->whereHas('cities', function ($qq) use ($cityIds) {
            $qq->whereIn('city.id', $cityIds);
        });
    }

    // 事業種類（複数）
    if (!empty($businessIds)) {
        $q->whereHas('businessTypes', function ($qq) use ($businessIds) {
            $qq->whereIn('business_types.id', $businessIds);
        });
    }

    // 受入性別（properties.gender_id）
    if (!empty($genderIds)) {
        $q->whereIn('gender_id', $genderIds);
    }

    // 建物タイプ（複数）
    if (!empty($buildingIds)) {
        $q->whereHas('buildingTypes', function ($qq) use ($buildingIds) {
            $qq->whereIn('building_types.id', $buildingIds);
        });
    }

    // 特徴（複数）
    if (!empty($featureIds)) {
        $q->whereHas('features', function ($qq) use ($featureIds) {
            $qq->whereIn('features.id', $featureIds);
        });
    }

    // 障がい者区分
    if ($request->filled('disability_level')) {
        $q->where('level_disability_id', (int)$request->input('disability_level'));
    }

    // 家賃 範囲
    if ($request->filled('rent_min')) {
        $q->where('rent', '>=', (int)$request->input('rent_min'));
    }
    if ($request->filled('rent_max')) {
        $q->where('rent', '<=', (int)$request->input('rent_max'));
    }

    // フリーワード
    if ($request->filled('q')) {
        $kw = trim((string)$request->input('q'));
        $q->where(function ($qq) use ($kw) {
            $qq->where('title', 'like', "%{$kw}%")
               ->orWhere('address', 'like', "%{$kw}%")
               ->orWhere('description', 'like', "%{$kw}%");
        });
    }

    // ページング（GET条件保持）
    $properties = $q->latest()
        ->paginate(10)
        ->appends($request->query());

    // 検索条件表示用 name
    $areaName = $areaId ? Area::where('id', $areaId)->value('name') : null;

    $cityNames = !empty($cityIds)
        ? City::whereIn('id', $cityIds)->pluck('name')->toArray()
        : [];

    $businessNames = !empty($businessIds)
        ? BusinessType::whereIn('id', $businessIds)->pluck('name')->toArray()
        : [];

    $genderNames = !empty($genderIds)
        ? Gender::whereIn('id', $genderIds)->pluck('name')->toArray()
        : [];

    $buildingNames = !empty($buildingIds)
        ? BuildingType::whereIn('id', $buildingIds)->pluck('name')->toArray()
        : [];

    $featureNames = !empty($featureIds)
        ? Feature::whereIn('id', $featureIds)->pluck('name')->toArray()
        : [];

    $disabilityName = $request->filled('disability_level')
        ? LevelDisability::where('id', (int)$request->input('disability_level'))->value('name')
        : null;

    return view('property.result', compact(
        'properties',
        'areaName',
        'cityNames',
        'businessNames',
        'genderNames',
        'buildingNames',
        'featureNames',
        'disabilityName'
    ));
}
}
