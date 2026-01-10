<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // ログイン画面
    public function showLoginForm()
    {
        return view('auth.login'); // あなたのログインblade名に合わせて変更OK
    }

    // ログイン処理（usersテーブルで認証）
    public function login(Request $request)
    {
        $credentials = $request->validate(
            [
                'email'    => ['required', 'email'],
                'password' => ['required', 'string'],
            ],
            [
                'email.required'    => 'メールアドレスを入力してください。',
                'email.email'       => '正しいメールアドレス形式で入力してください。',
                'password.required' => 'パスワードを入力してください。',
            ]
        );

        $remember = $request->boolean('remember');

        // ✅ users.email + users.password(ハッシュ) でログイン
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate(); // セッション固定攻撃対策
            return redirect()->intended(route('top'));
        }

        // 失敗
        return back()
            ->withErrors(['email' => 'メールアドレスまたはパスワードが違います。'])
            ->withInput($request->only('email'));
    }

    // （任意）ログアウトはweb.phpでやってるなら不要
}
