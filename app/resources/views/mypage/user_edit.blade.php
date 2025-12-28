@extends('layouts.app')
@section('title', '会員情報編集')

@section('content')
<h1 class="text-2xl font-bold">会員情報編集</h1>

<div class="bg-white border rounded-2xl shadow-sm p-6 mt-6 max-w-3xl mx-auto">
  <form method="POST" action="{{ route('user.confirm') }}" class="space-y-4">

    @csrf

    <div>
      <div class="font-semibold">メールアドレス</div>
      <input name="email" class="mt-2 w-full border rounded-xl px-3 py-2" placeholder="メールアドレス入力">
    </div>

    <div>
      <div class="font-semibold">パスワード</div>
      <input name="password" type="password" class="mt-2 w-full border rounded-xl px-3 py-2" placeholder="パスワード入力（英数字6文字以上）">
    </div>

    <div>
      <div class="font-semibold">パスワード確認</div>
      <input name="password_confirmation" type="password" class="mt-2 w-full border rounded-xl px-3 py-2" placeholder="パスワード確認入力">
    </div>

    <div>
      <div class="font-semibold">お名前</div>
      <input name="name" class="mt-2 w-full border rounded-xl px-3 py-2" placeholder="名前入力">
    </div>

    <div>
      <div class="font-semibold">生年月日</div>
      <input name="dob" type="date" class="mt-2 w-full border rounded-xl px-3 py-2">
    </div>

    <div class="flex flex-wrap justify-center gap-2 pt-2">
      <button class="px-6 py-3 rounded-2xl bg-blue-600 text-white font-semibold hover:bg-blue-700" type="submit">⑥ 保存</button>
      <a class="px-6 py-3 rounded-2xl border font-semibold hover:bg-slate-50" href="{{ route('mypage.user_info') }}">戻る</a>
    </div>
  </form>
</div>
@endsection
