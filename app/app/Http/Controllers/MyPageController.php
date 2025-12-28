<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MyPageController extends Controller
{
    // マイページ
    public function index()
    {
        return view('mypage.index');
    }

    // 会員情報表示
    public function show()
    {
        return view('mypage.user_info');
    }

    // 会員情報編集画面
    public function edit()
    {
        return view('mypage.user_edit');
    }

    // 会員情報編集 確認（今回は仮：保存扱いで戻す）
    public function confirm(Request $request)
    {
        // 本来は確認画面に遷移、または更新処理へ
        return redirect()->route('user.info');
    }

    // 退会（今回は仮）
    public function delete(Request $request)
    {
        // 本来はユーザー削除 → ログアウト等
        return redirect()->route('top');
    }
}
