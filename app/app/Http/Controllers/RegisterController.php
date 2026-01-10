<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function show()
    {
        return view('auth.signup');
    }

    public function confirm(Request $request)
    {
        $validated = $request->validate(
            [
                'email' => ['required', 'email', 'max:255', 'unique:users,email'],
                'password' => ['required', 'string', 'min:6', 'confirmed'],
                'name' => ['required', 'string', 'max:255'],
                'dob' => ['required', 'date'],
            ],
            [
                'email.required' => 'メールアドレスは必須です。',
                'email.email' => 'メールアドレスの形式が正しくありません。',
                'email.unique' => 'このメールアドレスは既に登録されています。',
                'password.required' => 'パスワードは必須です。',
                'password.min' => 'パスワードは6文字以上で入力してください。',
                'password.confirmed' => 'パスワード確認が一致しません。',
                'name.required' => 'お名前は必須です。',
                'dob.required' => '生年月日は必須です。',
                'dob.date' => '生年月日の形式が正しくありません。',
            ]
        );

        // confirm画面用にセッションへ（パスワードも保持）
        $request->session()->put('signup', [
            'email' => $validated['email'],
            'password' => $validated['password'], // completeでHash化する
            'name' => $validated['name'],
            'dob' => $validated['dob'],
        ]);

        return view('auth.signup_confirm');
    }

    public function back(Request $request)
    {
        // セッションが残っていれば old に流し込んで入力画面へ戻す
        $signup = $request->session()->get('signup', []);

        return redirect()
            ->route('signup')
            ->withInput([
                'email' => $signup['email'] ?? '',
                'name'  => $signup['name'] ?? '',
                'dob'   => $signup['dob'] ?? '',
            ]);
    }

    public function complete(Request $request)
    {
        $signup = $request->session()->get('signup');

        if (!$signup || empty($signup['email']) || empty($signup['password'])) {
            // セッション切れ/直アクセス対策
            return redirect()->route('signup')->withErrors([
                'signup' => 'セッションが切れました。もう一度入力してください。',
            ])->withInput();
        }

        // DB保存
        User::create([
            'name' => $signup['name'],
            'email' => $signup['email'],
            'password' => Hash::make($signup['password']),
            'dob' => $signup['dob'],
        ]);


        // セッション破棄
        $request->session()->forget('signup');

        return view('auth.signup_complete');
    }
}
