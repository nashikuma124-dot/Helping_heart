<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class MyPageController extends Controller
{
    /**
     * マイページトップ
     * GET /mypage
     */
    public function index()
    {
        return view('mypage.index');
    }

    /**
     * ✅ 会員情報ページ
     * GET /user
     */
    public function show()
    {
        $user = Auth::user();
        return view('mypage.user_info', compact('user'));
    }

    /**
     * ✅ 会員情報編集画面
     * GET /mypage/{mypage}/edit
     * resourceの仕様で {mypage} が付くが、実際は「自分」だけ編集
     */
    public function edit($id)
    {
        $user = Auth::user();
        return view('mypage.user_edit', compact('user'));
    }

    /**
     * ✅ 編集内容確認
     * POST /mypage/edit/confirm
     * → resources/views/mypage/user_edit_conf.blade.php
     */
    public function confirm(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'name' => ['required', 'string', 'max:100'],
            'dob'  => ['nullable', 'date'],

            // パスワードは「入力されたら更新」
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ], [
            'email.email' => '正しいメールアドレス形式で入力してください。',
            'email.unique' => 'そのメールアドレスは既に使われています。',
            'name.required' => 'お名前を入力してください。',
            'password.confirmed' => 'パスワード確認が一致しません。',
            'password.min' => 'パスワードは6文字以上で入力してください。',
        ]);

        // 空文字をnullへ
        $email = ($validated['email'] ?? '') !== '' ? $validated['email'] : null;
        $dob   = ($validated['dob'] ?? '') !== '' ? $validated['dob'] : null;

        // ✅ confirm→update で使うので「入力値」をセッションに保持
        // パスワードも更新したいので保持（平文が嫌ならconfirm画面で再入力方式にする必要あり）
        $payload = [
            'email' => $email,
            'name'  => $validated['name'],
            'dob'   => $dob,
            'password' => $validated['password'] ?? null,
        ];

        $request->session()->put('mypage_edit', $payload);

        // 表示用（passwordは伏せ字表示する）
        return view('mypage.user_edit_conf', [
            'data' => [
                'email' => $payload['email'],
                'name'  => $payload['name'],
                'dob'   => $payload['dob'],
                'has_password' => !empty($payload['password']),
            ],
        ]);
    }

    /**
     * ✅ 会員情報更新（POSTで更新）
     * POST /mypage/update
     * ※ PUT ではないので $id は取らない
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // ✅ confirmで保持した内容を使って更新（確認画面からの登録を想定）
        $data = $request->session()->get('mypage_edit');

        if (!$data) {
            // セッションが無い（直叩き/期限切れなど）
            return redirect()->route('mypage.edit', 1)->with('error', 'セッションが切れました。もう一度入力してください。');
        }

        // ここで最終ガード（念のため）
        $request->merge([
            'email' => $data['email'],
            'name'  => $data['name'],
            'dob'   => $data['dob'],
        ]);

        $validated = $request->validate([
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'name' => ['required', 'string', 'max:100'],
            'dob'  => ['nullable', 'date'],
        ]);

        // ✅ 保存（カラム名は dateofbirth 前提）
        $user->fill([
            'email'       => ($validated['email'] ?? '') !== '' ? $validated['email'] : null,
            'name'        => $validated['name'],
            'dateofbirth' => $validated['dob'] ?? $user->dateofbirth,
        ]);

        // ✅ パスワード更新（入力があった場合のみ）
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        // ✅ セッション破棄（再送防止）
        $request->session()->forget('mypage_edit');

        return redirect()->route('user.info')->with('success', '会員情報を更新しました。');
    }

    /**
     * ✅ 退会
     * POST /user/delete
     */
    public function delete(Request $request)
    {
        $user = Auth::user();

        $user->delete();

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('top')->with('success', '退会しました。');
    }
}
