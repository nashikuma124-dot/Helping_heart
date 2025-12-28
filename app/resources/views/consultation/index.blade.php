@extends('layouts.app')
@section('title', 'チャット相談窓口')

@section('content')
<h1 class="text-2xl font-bold">チャット相談窓口</h1>

<div class="grid md:grid-cols-2 gap-6 mt-6">
  <div class="bg-white border rounded-2xl shadow-sm p-6">
    <h2 class="font-bold">グループホーム相談</h2>
    <p class="text-sm text-slate-500 mt-2">LINE 友達追加 → チャット開始へ</p>
    <a class="inline-flex mt-4 px-6 py-3 rounded-2xl bg-blue-600 text-white font-semibold hover:bg-blue-700"
       href="{{ route('consultation.home') }}">友達追加へ</a>
  </div>

  <div class="bg-white border rounded-2xl shadow-sm p-6">
    <h2 class="font-bold">福祉サービス相談</h2>
    <p class="text-sm text-slate-500 mt-2">LINE 友達追加 → チャット開始へ</p>
    <a class="inline-flex mt-4 px-6 py-3 rounded-2xl bg-blue-600 text-white font-semibold hover:bg-blue-700"
       href="{{ route('consultation.welfare') }}">友達追加へ</a>
  </div>
</div>
@endsection
