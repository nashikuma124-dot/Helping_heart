<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login_mail');
    }

    public function login(Request $request)
    {
        // いったん画面遷移だけ通す用（本実装は後でOK）
        // Auth::attempt などはまだ入れなくて大丈夫
        return redirect()->route('mypage.index');
    }

    // パスワード再設定：メール入力画面（仮）
    public function reset()
    {
        // 画面をまだ作っていないなら一旦 error に飛ばしてもOK
        // return view('auth.password_reset'); などに後で差し替え
        return view('error');
    }

    // パスワード再設定：メール送信（仮）
    public function send(Request $request)
    {
        return redirect()->route('password.request');
    }

    // パスワード再設定：新パス入力フォーム（仮）
    public function form(string $token)
    {
        return view('error');
    }

    // パスワード再設定：完了（仮）
    public function complete(Request $request)
    {
        return redirect()->route('login');
    }
}
