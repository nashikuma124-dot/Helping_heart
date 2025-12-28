<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function show()
    {
        return view('auth.signup');
    }

    public function confirm(Request $request)
    {
        // 本来はバリデーションして確認画面へ
        return view('auth.signup_confirm', ['input' => $request->all()]);
    }

    public function complete(Request $request)
    {
        // 本来はユーザー作成して完了画面へ
        return view('auth.signup_complete');
    }
}
