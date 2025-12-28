<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PropertyController extends Controller
{
    // 検索画面
    public function search()
    {
        return view('property.search');
    }

    // 検索結果
    public function result(Request $request)
    {
        return view('property.result');
    }

    // 物件詳細
    public function show($property)
    {
        return view('property.detail', ['id' => $property]);
    }
}
