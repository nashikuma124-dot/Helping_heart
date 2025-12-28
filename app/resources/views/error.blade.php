@extends('layouts.app')
@section('title', 'エラー')

@section('content')
<div class="min-h-[60vh] grid place-items-center">
  <div class="bg-white border rounded-2xl shadow-sm p-8 w-full max-w-3xl text-center">
    <h1 class="text-2xl font-bold">エラーが発生しました</h1>
    <p class="text-slate-500 mt-2">お手数ですが、時間をおいて再度お試しください。</p>

    <div class="mt-8 flex flex-wrap justify-center gap-2">
      <a class="px-6 py-3 rounded-2xl bg-blue-600 text-white font-semibold hover:bg-blue-700" href="{{ url('/') }}">トップへ</a>
      <a class="px-6 py-3 rounded-2xl border font-semibold hover:bg-slate-50" href="javascript:history.back()">戻る</a>
    </div>
  </div>
</div>
@endsection
