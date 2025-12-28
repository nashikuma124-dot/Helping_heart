<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LineLoginController extends Controller
{
    // LINEログイン開始（本実装ではLINEの認可URLへリダイレクト）
    public function redirect()
    {
        // いったんデモとして「完了ページ」へ
        return redirect()->route('line.complete');
    }

    // LINEログインのコールバック（本実装では認可コードを処理）
    public function callback(Request $request)
    {
        // いったんデモとして「完了ページ」へ
        return redirect()->route('line.complete');
    }

    // 完了ページ
    public function complete()
    {
        // もしビューが無いなら error に変えてOK
        return view('error');
    }

    // エラーページ
    public function error()
    {
        return view('error');
    }
}
