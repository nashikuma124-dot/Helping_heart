@extends('layouts.app')
@section('title', '会員登録完了')

@section('content')
<div class="min-h-[60vh] grid place-items-center">
  <div class="bg-white border rounded-2xl shadow-sm p-8 w-full max-w-3xl text-center">
    <h1 class="text-2xl font-bold">会員登録が完了しました。</h1>
    <div class="mt-8">
      <a class="inline-flex px-6 py-3 rounded-2xl bg-blue-600 text-white font-semibold hover:bg-blue-700" href="{{ route('login') }}">
        ログイン画面へ
      </a>
    </div>
  </div>
</div>
@endsection
