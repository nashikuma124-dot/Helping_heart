<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function cities(Request $request)
    {
        $areaId = (int) $request->query('area_id');

        if ($areaId <= 0) {
            return response()->json([]);
        }

        $cities = City::where('area_id', $areaId)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($cities);
    }
}
