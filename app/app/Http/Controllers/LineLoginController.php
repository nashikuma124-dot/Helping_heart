<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class LineLoginController extends Controller
{
    public function redirect()
    {
        // LINEへ
        return Socialite::driver('line')
            ->scopes(['profile', 'openid', 'email'])
            ->redirect();
    }

    public function callback()
    {
        try {
            $lineUser = Socialite::driver('line')->user();
        } catch (\Throwable $e) {
            return redirect()->route('line.error');
        }

        // LINEのユーザーID（sub or id）
        $lineId = $lineUser->getId();
        $email  = $lineUser->getEmail(); // 取れない場合あり
        $name   = $lineUser->getName() ?: 'LINEユーザー';

        // 1) line_idで既存ユーザー検索
        $user = User::where('line_id', $lineId)->first();

        // 2) いなければ、emailが取れる場合はemailで紐付け
        if (!$user && $email) {
            $user = User::where('email', $email)->first();
        }

        // 3) それでも無ければ新規作成
        if (!$user) {
            $user = User::create([
                'name'     => $name,
                'email'    => $email ?: ('line_' . $lineId . '@example.local'),
                'password' => bcrypt(Str::random(32)),
                'line_id'  => $lineId,
            ]);
        } else {
            // 既存ユーザーにline_idが無ければ付与
            if (empty($user->line_id)) {
                $user->line_id = $lineId;
                $user->save();
            }
        }

        Auth::login($user, true);

        return redirect()->route('top');
    }

    public function complete()
    {
        return view('line.complete');
    }

    public function error()
    {
        return view('line.error');
    }
}
