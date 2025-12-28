@extends('layouts.app')
@section('title', 'マイページ')

@section('content')
<h1 class="text-2xl font-bold">マイページ</h1>

<div class="bg-white border rounded-2xl shadow-sm p-6 mt-6">
  <div class="grid md:grid-cols-2 gap-4">
    <a class="block text-center px-5 py-4 rounded-2xl bg-blue-600 text-white font-semibold hover:bg-blue-700" href="{{ route('property.search') }}">① 物件検索</a>
    <a class="block text-center px-5 py-4 rounded-2xl bg-blue-600 text-white font-semibold hover:bg-blue-700" href="{{ route('favorite.index') }}">② お気に入り物件一覧</a>
    <a class="block text-center px-5 py-4 rounded-2xl border font-semibold hover:bg-slate-50" href="{{ route('consultation.index') }}">③ LINE相談案内</a>
    <a class="block text-center px-5 py-4 rounded-2xl border font-semibold hover:bg-slate-50" href="{{ route('user.info') }}">④ 会員情報</a>
  </div>
</div>
@endsection
