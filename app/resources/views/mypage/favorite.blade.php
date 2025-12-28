@extends('layouts.app')
@section('title', 'お気に入り物件一覧')

@section('content')
<h1 class="text-2xl font-bold">お気に入り物件一覧</h1>

<div class="bg-white border rounded-2xl shadow-sm p-6 mt-6">
  <p class="text-sm text-slate-500">※仕様書：1ページ10件／掲載日が新しい順</p>

  <div class="grid md:grid-cols-2 gap-4 mt-4">
    @foreach([['id'=>2001,'title'=>'物件情報（お気に入り）1','meta'=>'東京都〇〇区 / 空室：あり'],
              ['id'=>2002,'title'=>'物件情報（お気に入り）2','meta'=>'大阪府〇〇市 / 空室：なし']] as $p)
      <div class="border rounded-2xl p-4">
        <div class="font-extrabold">{{ $p['title'] }}</div>
        <div class="text-sm text-slate-500 mt-1">{{ $p['meta'] }}</div>

        <div class="mt-3 flex flex-wrap gap-2">
          <a class="px-4 py-2 rounded-full bg-blue-600 text-white hover:bg-blue-700" href="{{ route('property.detail', $p['id']) }}">詳細</a>
          <button class="px-4 py-2 rounded-full border hover:bg-slate-50" type="button">♡ 解除</button>
        </div>
      </div>
    @endforeach
  </div>
</div>
@endsection
