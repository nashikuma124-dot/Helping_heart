@extends('layouts.app')
@section('title', '管理者ページ')

@section('content')
<h1 class="text-2xl font-bold">管理者ページ</h1>

<div class="bg-white border rounded-2xl shadow-sm p-6 mt-6">
  <div class="grid md:grid-cols-3 gap-4">
    <a class="block text-center px-5 py-4 rounded-2xl bg-blue-600 text-white font-semibold hover:bg-blue-700"
       href="{{ route('admin.properties.index') }}">物件データ管理</a>

    <a class="block text-center px-5 py-4 rounded-2xl bg-blue-600 text-white font-semibold hover:bg-blue-700"
       href="{{ route('admin.users.index') }}">会員ユーザー管理</a>

    <a class="block text-center px-5 py-4 rounded-2xl bg-blue-600 text-white font-semibold hover:bg-blue-700"
       href="{{ route('admin.inquiries.index') }}">ユーザー問い合わせ管理</a>

    <a class="block text-center px-5 py-4 rounded-2xl border font-semibold hover:bg-slate-50" href="{{ route('top') }}">トップへ</a>
    <a class="block text-center px-5 py-4 rounded-2xl border font-semibold hover:bg-slate-50" href="{{ route('error') }}">エラー画面（例）</a>
  </div>
</div>
@endsection
