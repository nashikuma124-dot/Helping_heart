@extends('layouts.app')
@section('title', '物件詳細')

@section('content')
<h1 class="text-2xl font-bold">物件詳細</h1>

@php
  $p = [
    'title' => 'サンプル物件A',
    'address' => '東京都〇〇区〇〇 1-2-3',
    'total' => 100000,
    'business' => '〇〇事業者',
  ];
@endphp

<div class="grid lg:grid-cols-3 gap-6 mt-6">
  <div class="lg:col-span-2 bg-white border rounded-2xl shadow-sm p-6">
    <div class="flex items-start justify-between gap-3">
      <div>
        <div class="text-xl font-extrabold">{{ $p['title'] }}</div>
        <div class="text-sm text-slate-500 mt-1">住所：{{ $p['address'] }}</div>
      </div>
      <a class="px-4 py-2 rounded-full border hover:bg-slate-50" href="{{ route('mypage.favorite') }}">♡ お気に入り登録</a>
    </div>

    <div class="mt-6 grid grid-cols-3 gap-3 items-center">
      <button class="px-4 py-2 rounded-xl border hover:bg-slate-50">◀</button>
      <div class="aspect-video rounded-2xl border bg-gradient-to-br from-slate-100 to-white grid place-items-center text-slate-500 font-bold">
        物件画像（スライド想定）
      </div>
      <button class="px-4 py-2 rounded-xl border hover:bg-slate-50">▶</button>
    </div>

    <div class="mt-6 flex flex-wrap gap-2">
      <a href="#about" class="px-4 py-2 rounded-full border text-blue-600 border-blue-600">基本情報</a>
      <a href="#fees" class="px-4 py-2 rounded-full border hover:bg-slate-50">料金</a>
      <a href="#features" class="px-4 py-2 rounded-full border hover:bg-slate-50">特徴</a>
      <a href="#access" class="px-4 py-2 rounded-full border hover:bg-slate-50">アクセス</a>
    </div>

    <h2 id="fees" class="mt-8 font-bold">支払合計金額：<span class="inline-block px-2 py-1 text-sm rounded-full border">{{ number_format($p['total']) }} 円</span></h2>

    <div class="overflow-x-auto mt-3">
      <table class="w-full border text-sm">
        <tr class="bg-slate-50">
          <th class="border px-3 py-2 text-left">家賃</th><td class="border px-3 py-2">〇〇,〇〇〇円</td>
          <th class="border px-3 py-2 text-left">水道光熱費</th><td class="border px-3 py-2">〇〇,〇〇〇円</td>
        </tr>
        <tr>
          <th class="border px-3 py-2 text-left">食材料費</th><td class="border px-3 py-2">〇〇,〇〇〇円</td>
          <th class="border px-3 py-2 text-left">日用品費</th><td class="border px-3 py-2">〇〇,〇〇〇円</td>
        </tr>
        <tr class="bg-slate-50">
          <th class="border px-3 py-2 text-left">その他費用</th><td class="border px-3 py-2">〇〇,〇〇〇円</td>
          <th class="border px-3 py-2 text-left">小計</th><td class="border px-3 py-2">〇〇,〇〇〇円</td>
        </tr>
      </table>
    </div>

    <h2 id="about" class="mt-8 font-bold">基本情報</h2>
    <div class="mt-3 border rounded-2xl overflow-hidden">
      <div class="grid grid-cols-[220px_1fr] text-sm">
        @php
          $rows = [
            ['事業者名', $p['business']],
            ['空室状況', '空室あり'],
            ['定員', '6名'],
            ['受入性別', '男女可'],
            ['建物タイプ', 'マンション'],
            ['説明', 'ここに物件説明が入ります。'],
          ];
        @endphp
        @foreach($rows as [$k,$v])
          <div class="bg-slate-50 border-b px-3 py-2 font-semibold">{{ $k }}</div>
          <div class="border-b px-3 py-2">{{ $v }}</div>
        @endforeach
      </div>
    </div>

    <h2 id="features" class="mt-8 font-bold">特徴</h2>
    <p class="text-sm text-slate-500 mt-2">（仕様に合わせて表示する想定）</p>

    <h2 id="access" class="mt-8 font-bold">アクセス</h2>
    <p class="text-sm text-slate-500 mt-2">（地図/最寄駅表示などを想定）</p>
  </div>

  <aside class="bg-white border rounded-2xl shadow-sm p-6">
    <h2 class="font-bold">アクション</h2>
    <div class="mt-4 space-y-2">
      <a class="block text-center px-5 py-3 rounded-2xl bg-blue-600 text-white font-semibold hover:bg-blue-700"
         href="{{ route('inquiry.form', request('id', 1001)) }}">お問い合わせ</a>
      <a class="block text-center px-5 py-3 rounded-2xl border font-semibold hover:bg-slate-50"
         href="{{ route('consultation.index') }}">LINE相談へ</a>
      <a class="block text-center px-5 py-3 rounded-2xl border font-semibold hover:bg-slate-50"
         href="{{ route('property.result') }}">検索結果へ戻る</a>
    </div>
    <p class="text-xs text-slate-500 mt-4">※お問い合わせは「問い合わせページ」へ遷移</p>
  </aside>
</div>
@endsection
