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
     * 会員情報ページ
     * GET /user
     */
    public function show()
    {
        $user = Auth::user();
        return view('mypage.user_info', compact('user'));
    }

    /**
     * 会員情報編集画面
     * GET /mypage/{mypage}/edit
     * ※resourceの仕様で {mypage} が付くが、自分だけ編集
     */
    public function edit($mypage)
    {
        $user = Auth::user();
        return view('mypage.user_edit', compact('user'));
    }

    /**
     * 編集内容確認
     * POST /mypage/edit/confirm
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
            // パスワードは入力されたら更新
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ], [
            'email.email' => '正しいメールアドレス形式で入力してください。',
            'email.unique' => 'そのメールアドレスは既に使われています。',
            'name.required' => 'お名前を入力してください。',
            'password.confirmed' => 'パスワード確認が一致しません。',
            'password.min' => 'パスワードは6文字以上で入力してください。',
        ]);

        // 空文字→null
        $email = ($validated['email'] ?? '') !== '' ? $validated['email'] : null;
        $dob   = ($validated['dob'] ?? '') !== '' ? $validated['dob'] : null;

        // confirm→update で使う入力値をセッションへ
        $payload = [
            'email'    => $email,
            'name'     => $validated['name'],
            'dob'      => $dob,
            'password' => $validated['password'] ?? null, // 平文保持（課題仕様優先）
        ];

        $request->session()->put('mypage_edit', $payload);

        // 表示用（パスワードは伏せ字）
        $viewData = [
            'email'        => $payload['email'],
            'name'         => $payload['name'],
            'dob'          => $payload['dob'],
            'has_password' => !empty($payload['password']),
        ];

        // Bladeが session('mypage_edit') を直接読んでも、$dataを使っても動くように
        return view('mypage.user_edit_conf', compact('viewData'))
            ->with('data', $viewData);
    }

    /**
     * 会員情報更新
     * POST /mypage/update
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // confirmで保持した内容を使って更新（確認画面からの登録想定）
        $data = $request->session()->get('mypage_edit');

        if (!$data) {
            // セッション切れ対策：自分のeditへ戻す（←ここ重要）
            return redirect()
                ->route('mypage.edit', auth()->id())
                ->with('error', 'セッションが切れました。もう一度入力してください。');
        }

        /**
         * ✅ 最終ガード（セッション値でも再バリデーション）
         * セッションが書き換えられてもDBに入らないようにする
         */
        $validated = validator($data, [
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'name' => ['required', 'string', 'max:100'],
            'dob'  => ['nullable', 'date'],
            'password' => ['nullable', 'string', 'min:6'], // confirmedはconfirm側で済ませている
        ])->validate();

        // ✅ 保存（あなたのDB設計：dateofbirthカラム前提）
        $user->email = ($validated['email'] ?? '') !== '' ? $validated['email'] : null;
        $user->name  = $validated['name'];

        // 生年月日：入力が無ければnullにしたい場合は下の通り
        // 「空なら既存維持」にしたいなら、elseで何もしない、に変えてOK
        $user->dob = $validated['dob'] ?? null;

        // ✅ パスワード更新（入力があった場合のみ）
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        // ✅ セッション破棄（再送防止）
        $request->session()->forget('mypage_edit');

        return redirect()
            ->route('user.info')
            ->with('success', '会員情報を更新しました。');
    }

    /**
     * 退会
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

    /**
    * ✅ 退会確認画面
    * GET /user/delete/confirm
    */
    public function deleteConfirm()
    {
        $user = Auth::user();
        return view('mypage.user_delete_conf', compact('user'));
    }
}
