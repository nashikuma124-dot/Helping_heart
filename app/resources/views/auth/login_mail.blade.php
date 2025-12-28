@extends('layouts.app')
@section('title', 'ログイン（e-mail）')

@section('content')
<h1 class="text-2xl font-bold">ログイン</h1>

<div class="bg-white border rounded-2xl shadow-sm p-6 mt-6 max-w-3xl mx-auto">
  <form method="POST" action="{{ route('login') }}" class="space-y-5">
    @csrf
    <div>
      <div class="font-semibold">メールアドレス</div>
      <input type="email" name="email" class="mt-2 w-full border rounded-xl px-3 py-2" placeholder="メールアドレス入力" required>
    </div>

    <div>
      <div class="font-semibold">パスワード</div>
      <input type="password" name="password" class="mt-2 w-full border rounded-xl px-3 py-2" placeholder="パスワード入力" required>
    </div>

    <div class="text-sm">
      <a class="text-blue-600 hover:underline" href="{{ route('password.request') }}">③ パスワードを忘れた方はこちら</a>
    </div>

    <div class="flex flex-wrap justify-center gap-2 pt-2">
      <button class="px-6 py-3 rounded-2xl bg-blue-600 text-white font-semibold hover:bg-blue-700">④ ログイン</button>
      <a class="px-6 py-3 rounded-2xl border font-semibold hover:bg-slate-50" href="{{ route('line.login') }}">⑤ LINEでログイン</a>
    </div>
  </form>
</div>
@endsection
