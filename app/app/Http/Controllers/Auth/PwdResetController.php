<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

// ✅ 追加
use App\User;
use Illuminate\Support\Facades\DB;

class PwdResetController extends Controller
{
    // メール入力画面（②メール送信がある画面）
    public function showRequestForm()
    {
        return view('auth.pwd_reset');
    }

    // ② メール送信 → 再設定リンク送信
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $status = Password::sendResetLink($request->only('email'));

        return ($status === Password::RESET_LINK_SENT)
            ? back()->with('status', trans($status))
            : back()->withErrors(['email' => trans($status)]);
    }

    // メールのリンク → pwd_form.blade.php を表示
    public function showResetForm($token, Request $request)
    {
        return view('auth.pwd_form', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    // ✅ 新パスワード登録（更新）→ 完了画面へ
    public function resetPassword(Request $request)
    {
        // バリデーション
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        // ✅ トークンが正しいか確認（password_resets に該当が無いと不正扱い）
        $reset = DB::table('password_resets')
            ->where('email', $request->email)
            ->first();

        if (!$reset || !Hash::check($request->token, $reset->token)) {
            return back()->withErrors(['email' => 'この再設定リンクは無効、または期限切れです。']);
        }

        // パスワード更新処理
        User::where('email', $request->email)->update([
            'password' => bcrypt($request->password),
            'remember_token' => Str::random(60),
        ]);

        // トークン削除
        DB::table('password_resets')->where('email', $request->email)->delete();

        // 完了画面へ
        return redirect()->route('password.complete');
    }
}
