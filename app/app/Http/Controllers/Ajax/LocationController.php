<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function cities(Request $request)
    {
        $areaId = $request->query('area_id');

        return City::where('area_id', $areaId)
            ->orderBy('sort_order')
            ->get(['id', 'name']);
    }
}
