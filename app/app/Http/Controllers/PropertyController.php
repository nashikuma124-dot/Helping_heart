<?php

namespace App\Http\Controllers;

use App\Models\BusinessType;
use App\Models\Gender;
use App\Models\BuildingType;
use App\Models\Feature;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        // 仮：一覧表示（あとで検索条件を追加してOK）
        $properties = Property::query()->latest()->paginate(10);
        return view('property.index', compact('properties'));
    }

    public function show(Property $property)
    {
        return view('property.show', compact('property'));
    }

    // 検索画面
    public function search()
    {
        $businessTypes = BusinessType::orderBy('sort_order')->get();
        $genders       = Gender::orderBy('sort_order')->get();
        $buildingTypes = BuildingType::orderBy('sort_order')->get();
        $features      = Feature::orderBy('sort_order')->get();

        return view('property.search', compact(
            'businessTypes', 'genders', 'buildingTypes', 'features'
        ));
    }

    // 検索結果
    public function result(Request $request)
    {
        // 例：area_id と city_id で絞り込み（必要に応じて増やす）
        $q = Property::query();

        if ($request->filled('area_id')) {
            $areaId = (int)$request->area_id;

            // property_city を使って city 経由で絞る想定（未実装ならコメントアウト）
            // $q->whereHas('cities', fn($qq) => $qq->where('area_id', $areaId));
        }

        if ($request->filled('city_id')) {
            $cityId = (int)$request->city_id;

            // $q->whereHas('cities', fn($qq) => $qq->where('city.id', $cityId));
        }

        $properties = $q->latest()->paginate(10)->withQueryString();
        return view('property.result', compact('properties'));
    }
}
