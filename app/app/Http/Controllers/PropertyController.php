<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\City;
use App\Models\Property;
use Illuminate\Http\Request;

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
        $areas = Area::orderBy('sort_order')->get();
        return view('property.search', compact('areas'));
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
