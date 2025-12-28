@extends('layouts.app')
@section('title', 'お問い合わせ')

@section('content')
<h1 class="text-2xl font-bold">お問い合わせ</h1>

<div class="bg-white border rounded-2xl shadow-sm p-6 mt-6 max-w-3xl mx-auto">
  <form method="POST" action="{{ route('inquiry.confirm') }}" class="space-y-5">
    @csrf

    <div>
      <div class="font-semibold">1. お問い合わせ内容</div>
      <div class="mt-2 flex flex-wrap gap-2">
        <label class="px-3 py-2 rounded-full border bg-white">
          <input class="mr-2" type="radio" name="type" value="plan" checked>プランや料金の詳細を知りたい
        </label>
        <label class="px-3 py-2 rounded-full border bg-white">
          <input class="mr-2" type="radio" name="type" value="visit">見学を希望したい
        </label>
        <label class="px-3 py-2 rounded-full border bg-white">
          <input class="mr-2" type="radio" name="type" value="other">その他のお問い合わせ
        </label>
      </div>
      <p class="text-xs text-slate-500 mt-1">※選択肢は仕様書ワイヤー準拠</p>
    </div>

    <div>
      <div class="font-semibold">詳細内容（任意）</div>
      <textarea name="content" class="mt-2 w-full border rounded-xl px-3 py-2 min-h-[120px]" placeholder="詳細内容を記入"></textarea>
    </div>

    <div>
      <div class="font-semibold">2. お名前</div>
      <input name="name" class="mt-2 w-full border rounded-xl px-3 py-2" placeholder="お名前を入力" required>
    </div>

    <div>
      <div class="font-semibold">3. メールアドレス</div>
      <input type="email" name="email" class="mt-2 w-full border rounded-xl px-3 py-2" placeholder="メールアドレスを入力" required>
    </div>

    <div>
      <div class="font-semibold">4. 電話番号</div>
      <input name="tel" class="mt-2 w-full border rounded-xl px-3 py-2" placeholder="電話番号を入力">
    </div>

    <input type="hidden" name="property_id" value="{{ request('property_id') }}">

    <button class="w-full px-5 py-3 rounded-2xl bg-blue-600 text-white font-semibold hover:bg-blue-700">
      確認画面へ
    </button>
  </form>
</div>
@endsection
