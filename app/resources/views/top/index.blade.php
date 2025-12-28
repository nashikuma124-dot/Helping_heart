@extends('layouts.app')

@section('title', 'トップ')

@section('content')
<div class="min-h-[60vh] grid place-items-center">
  <div class="bg-white border rounded-2xl shadow-sm p-8 w-full max-w-3xl">
    <h1 class="text-2xl font-bold">トップページ</h1>
    <p class="text-slate-500 mt-2">目的を選んで進んでください。</p>

    <div class="grid md:grid-cols-2 gap-4 mt-8">
      <a href="{{ route('property.search') }}" class="block text-center px-5 py-4 rounded-2xl bg-blue-600 text-white font-semibold hover:bg-blue-700">① 物件検索</a>
      <a href="{{ route('consultation.index') }}" class="block text-center px-5 py-4 rounded-2xl bg-blue-600 text-white font-semibold hover:bg-blue-700">② LINE相談</a>
      <a href="{{ route('signup') }}" class="block text-center px-5 py-4 rounded-2xl border font-semibold hover:bg-slate-50">③ 会員登録</a>
      <a href="{{ route('login') }}" class="block text-center px-5 py-4 rounded-2xl border font-semibold hover:bg-slate-50">④ ログイン</a>
    </div>
  </div>
</div>
@endsection
