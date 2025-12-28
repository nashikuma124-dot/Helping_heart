@extends('layouts.app')
@section('title', '会員情報')

@section('content')
<h1 class="text-2xl font-bold">会員情報</h1>

<div class="bg-white border rounded-2xl shadow-sm p-6 mt-6 max-w-3xl mx-auto">
  <div class="overflow-x-auto">
    <table class="w-full border text-sm">
      <tr class="bg-slate-50"><th class="border px-3 py-2 text-left w-56">メールアドレス</th><td class="border px-3 py-2">xxxxx@example.com</td></tr>
      <tr><th class="border px-3 py-2 text-left">パスワード</th><td class="border px-3 py-2">********</td></tr>
      <tr class="bg-slate-50"><th class="border px-3 py-2 text-left">お名前</th><td class="border px-3 py-2">xxxxx</td></tr>
      <tr><th class="border px-3 py-2 text-left">生年月日</th><td class="border px-3 py-2">xxxx.xx.xx</td></tr>
    </table>
  </div>

  <div class="mt-6">
    <a class="inline-flex px-6 py-3 rounded-2xl bg-blue-600 text-white font-semibold hover:bg-blue-700" href="{{ route('user.edit') }}">
        ① 会員情報を変更する
    </a>

  </div>
</div>
@endsection
