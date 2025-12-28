@extends('layouts.app')
@section('title', 'お問い合わせ確認')

@section('content')
<h1 class="text-2xl font-bold">お問い合わせ内容確認</h1>

<div class="bg-white border rounded-2xl shadow-sm p-6 mt-6 max-w-4xl mx-auto">
  <h2 class="font-bold">入力内容</h2>

  <div class="mt-4 border rounded-2xl overflow-hidden text-sm">
    <div class="grid grid-cols-[220px_1fr]">
      <div class="bg-slate-50 border-b px-3 py-2 font-semibold">お問い合わせ内容</div>
      <div class="border-b px-3 py-2">{{ old('type', request('type','plan')) }}</div>

      <div class="bg-slate-50 border-b px-3 py-2 font-semibold">お名前</div>
      <div class="border-b px-3 py-2">{{ old('name', request('name','xxxx')) }}</div>

      <div class="bg-slate-50 border-b px-3 py-2 font-semibold">メールアドレス</div>
      <div class="border-b px-3 py-2">{{ old('email', request('email','xxxx')) }}</div>

      <div class="bg-slate-50 border-b px-3 py-2 font-semibold">電話番号</div>
      <div class="border-b px-3 py-2">{{ old('tel', request('tel','xxxx')) }}</div>
    </div>
  </div>

  <h2 class="font-bold mt-8">問い合わせ物件</h2>
  <div class="mt-4 border rounded-2xl overflow-hidden text-sm">
    <div class="grid grid-cols-[220px_1fr]">
      <div class="bg-slate-50 border-b px-3 py-2 font-semibold">物件ID</div>
      <div class="border-b px-3 py-2">{{ request('property_id','xxxx') }}</div>

      <div class="bg-slate-50 border-b px-3 py-2 font-semibold">物件名</div>
      <div class="border-b px-3 py-2">xxxx</div>

      <div class="bg-slate-50 border-b px-3 py-2 font-semibold">住所</div>
      <div class="border-b px-3 py-2">xxxx</div>

      <div class="bg-slate-50 border-b px-3 py-2 font-semibold">家賃・支払合計金額</div>
      <div class="border-b px-3 py-2">xxxx</div>

      <div class="bg-slate-50 border-b px-3 py-2 font-semibold">事業所</div>
      <div class="border-b px-3 py-2">xxxx</div>
    </div>
  </div>

  <div class="mt-8 flex flex-wrap justify-center gap-2">
    <a class="px-4 py-2 rounded-full border hover:bg-slate-50" href="{{ url()->previous() }}">入力に戻る</a>

    <form method="POST" action="{{ route('inquiry.complete') }}">
      @csrf
      <button class="px-5 py-2 rounded-full bg-blue-600 text-white font-semibold hover:bg-blue-700" type="submit">送信</button>
    </form>
  </div>
</div>
@endsection
