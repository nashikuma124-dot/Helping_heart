@extends('layouts.app')
@section('title', '福祉サービス相談 友達追加')

@section('content')
<h1 class="text-2xl font-bold">福祉サービス相談（LINE友達追加）</h1>

<div class="bg-white border rounded-2xl shadow-sm p-6 mt-6 max-w-4xl mx-auto text-center">
  <div class="aspect-[16/6] rounded-2xl border bg-gradient-to-br from-slate-100 to-white grid place-items-center text-slate-500 font-bold">
    QRコード / 友達追加導線（想定）
  </div>

  <p class="text-sm text-slate-500 mt-4">LINEで友達追加が完了したら、下のボタンからチャットを開始します。</p>

 <a class="inline-flex mt-6 px-6 py-3 rounded-2xl bg-blue-600 text-white font-semibold hover:bg-blue-700"
   href="{{ route('consultation.welfare.chat') }}">チャット開始</a>

</div>
@endsection
