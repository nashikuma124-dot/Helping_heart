@extends('layouts.app')
@section('title', '検索結果一覧')

@section('content')
<h1 class="text-2xl font-bold">検索結果一覧</h1>

<div class="grid lg:grid-cols-2 gap-6 mt-6">
  <div class="bg-white border rounded-2xl shadow-sm p-6">
    <h2 class="font-bold">条件</h2>
    <p class="text-sm text-slate-500 mt-2">URLパラメータ（pref/city/qなど）を表示する想定</p>

    <div class="mt-4 text-sm">
      <div>都道府県：{{ request('pref') ?: '—' }}</div>
      <div>市区町村：{{ request('city') ?: '—' }}</div>
      <div>キーワード：{{ request('q') ?: '—' }}</div>
    </div>

    <div class="mt-6">
      <a class="inline-flex px-4 py-2 rounded-full border hover:bg-slate-50" href="{{ route('property.search') }}">
        検索条件を変更
      </a>
    </div>
  </div>

  <div class="bg-white border rounded-2xl shadow-sm p-6">
    <h2 class="font-bold">結果</h2>
    <p class="text-sm text-slate-500 mt-2">※仕様書：1ページ10件／掲載日が新しい順</p>

    <div class="mt-4 space-y-4">
      @php
        $items = [
          ['id'=>1001,'title'=>'物件情報 1','address'=>'東京都〇〇区','vacant'=>'あり','capacity'=>5],
          ['id'=>1002,'title'=>'物件情報 2','address'=>'東京都〇〇区','vacant'=>'あり','capacity'=>6],
          ['id'=>1003,'title'=>'物件情報 3','address'=>'大阪府〇〇市','vacant'=>'なし','capacity'=>6],
        ];
      @endphp

      @foreach($items as $p)
        <div class="border rounded-2xl p-4">
          <div class="flex items-start justify-between gap-3">
            <div>
              <div class="font-extrabold">{{ $p['title'] }}</div>
              <div class="text-sm text-slate-500 mt-1">住所：{{ $p['address'] }} / 空室：{{ $p['vacant'] }} / 定員：{{ $p['capacity'] }}名</div>
            </div>
            <span class="text-xs px-2 py-1 rounded-full border text-slate-600">#{{ $p['id'] }}</span>
          </div>

          <div class="mt-3 flex flex-wrap gap-2">
            <a class="px-4 py-2 rounded-full bg-blue-600 text-white hover:bg-blue-700"
               href="{{ route('property.detail', ['id'=>$p['id']]) }}">詳細</a>
            <a class="px-4 py-2 rounded-full border hover:bg-slate-50"
               href="{{ route('mypage.favorite') }}">お気に入りへ</a>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</div>
@endsection
