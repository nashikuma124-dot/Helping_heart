@extends('layouts.app')
@section('title', 'お問い合わせ完了')

@section('content')
<div class="min-h-[60vh] grid place-items-center">
  <div class="bg-white border rounded-2xl shadow-sm p-8 w-full max-w-3xl text-center">
    <h1 class="text-2xl font-bold">お問い合わせが完了しました</h1>
    <p class="text-slate-500 mt-2">担当者からご連絡いたしますので、しばらくお待ちください。</p>

    <div class="mt-8">
      <a class="inline-flex px-6 py-3 rounded-2xl bg-blue-600 text-white font-semibold hover:bg-blue-700" href="{{ url('/') }}">
        トップへ戻る
      </a>
    </div>
  </div>
</div>
@endsection
