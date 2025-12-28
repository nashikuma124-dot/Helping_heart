<?php

namespace App\Http\Controllers;

class FavoriteController extends Controller
{
    // 一覧
    public function index()
    {
        return view('mypage.favorite');
    }

    // 登録（仮）
    public function store($property)
    {
        return back();
    }

    // 削除（仮）
    public function destroy($property)
    {
        return back();
    }
}
