@extends('layouts.app')
@section('title', '物件検索')

@section('content')
<h1 class="text-2xl font-bold">物件検索</h1>

<div class="bg-white border rounded-2xl shadow-sm p-6 mt-6">
  <form method="GET" action="{{ route('property.result') }}" class="space-y-6">
    <div class="grid md:grid-cols-2 gap-4">
      <div>
        <label class="font-semibold">都道府県</label>
        <select name="pref" class="mt-2 w-full border rounded-xl px-3 py-2">
          <option value="">都道府県を選択</option>
          <option>東京都</option><option>神奈川県</option><option>大阪府</option>
        </select>
        <p class="text-xs text-slate-500 mt-1">※仕様書：都道府県選択</p>
      </div>

      <div>
        <label class="font-semibold">市区町村</label>
        <select name="city" class="mt-2 w-full border rounded-xl px-3 py-2">
          <option value="">市区町村を選択</option>
          <option>〇〇区</option><option>〇〇市</option>
        </select>
        <p class="text-xs text-slate-500 mt-1">※都道府県選択に応じて変動想定</p>
      </div>

      <div>
        <label class="font-semibold">事業種類</label>
        <div class="mt-2 flex flex-wrap gap-2">
          <label class="px-3 py-2 rounded-full border bg-white">
            <input type="checkbox" name="business[]" value="home" class="mr-2">グループホーム
          </label>
          <label class="px-3 py-2 rounded-full border bg-white">
            <input type="checkbox" name="business[]" value="welfare" class="mr-2">福祉サービス
          </label>
        </div>
      </div>

      <div>
        <label class="font-semibold">障害者 区分</label>
        <div class="mt-2 flex flex-wrap gap-2">
          @for($i=1;$i<=3;$i++)
            <label class="px-3 py-2 rounded-full border bg-white">
              <input type="checkbox" name="level[]" value="{{ $i }}" class="mr-2">区分{{ $i }}
            </label>
          @endfor
        </div>
      </div>

      <div>
        <label class="font-semibold">家賃</label>
        <select name="rent" class="mt-2 w-full border rounded-xl px-3 py-2">
          <option value="">金額を選択</option>
          <option value="50000">〜50,000円</option>
          <option value="80000">〜80,000円</option>
          <option value="100000">〜100,000円</option>
        </select>
      </div>

      <div>
        <label class="font-semibold">受入性別</label>
        <select name="gender" class="mt-2 w-full border rounded-xl px-3 py-2">
          <option value="">性別を選択</option>
          <option value="male">男性</option>
          <option value="female">女性</option>
          <option value="any">男女可</option>
        </select>
      </div>

      <div>
        <label class="font-semibold">建物タイプ</label>
        <div class="mt-2 flex flex-wrap gap-2">
          <label class="px-3 py-2 rounded-full border bg-white"><input type="checkbox" name="building[]" value="house" class="mr-2">戸建て</label>
          <label class="px-3 py-2 rounded-full border bg-white"><input type="checkbox" name="building[]" value="mansion" class="mr-2">マンション</label>
          <label class="px-3 py-2 rounded-full border bg-white"><input type="checkbox" name="building[]" value="apartment" class="mr-2">アパート</label>
        </div>
      </div>

      <div>
        <label class="font-semibold">その他情報</label>
        <div class="mt-2 flex flex-wrap gap-2">
          <label class="px-3 py-2 rounded-full border bg-white"><input type="checkbox" name="feature[]" value="barrierfree" class="mr-2">バリアフリー</label>
          <label class="px-3 py-2 rounded-full border bg-white"><input type="checkbox" name="feature[]" value="meals" class="mr-2">食事提供</label>
          <label class="px-3 py-2 rounded-full border bg-white"><input type="checkbox" name="feature[]" value="support" class="mr-2">生活サポート</label>
        </div>
      </div>

      <div class="md:col-span-2">
        <label class="font-semibold">フリーワード</label>
        <input name="q" class="mt-2 w-full border rounded-xl px-3 py-2" placeholder="例）駅近／バリアフリー／〇〇区 など">
      </div>
    </div>

    <button class="w-full px-5 py-3 rounded-2xl bg-blue-600 text-white font-semibold hover:bg-blue-700">
      検索
    </button>
  </form>
</div>
@endsection
