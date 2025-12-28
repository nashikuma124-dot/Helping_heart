@extends('layouts.app')
@section('title', '会員登録確認')

@section('content')
<h1 class="text-2xl font-bold">会員登録 入力内容確認</h1>

<div class="bg-white border rounded-2xl shadow-sm p-6 mt-6 max-w-3xl mx-auto">
  <div class="overflow-x-auto">
    <table class="w-full border text-sm">
      <tr class="bg-slate-50"><th class="border px-3 py-2 text-left w-56">メールアドレス</th><td class="border px-3 py-2">xxxxx</td></tr>
      <tr><th class="border px-3 py-2 text-left">パスワード</th><td class="border px-3 py-2">********</td></tr>
      <tr class="bg-slate-50"><th class="border px-3 py-2 text-left">お名前</th><td class="border px-3 py-2">xxxxx</td></tr>
      <tr><th class="border px-3 py-2 text-left">生年月日</th><td class="border px-3 py-2">xxxx.xx.xx</td></tr>
    </table>
  </div>

  <div class="mt-6 flex flex-wrap justify-center gap-2">
    <a class="px-4 py-2 rounded-full border hover:bg-slate-50" href="{{ route('signup') }}">① 入力に戻る</a>

    <form method="POST" action="{{ route('signup.complete') }}">
      @csrf
      <button class="px-5 py-2 rounded-full bg-blue-600 text-white font-semibold hover:bg-blue-700" type="submit">② 登録</button>
    </form>
  </div>
</div>
@endsection
