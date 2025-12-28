@extends('layouts.app')
@section('title', 'グループホーム チャット')

@section('content')
<h1 class="text-2xl font-bold">グループホーム相談（チャット）</h1>

<div class="bg-white border rounded-2xl shadow-sm p-6 mt-6">
  <div class="border rounded-2xl overflow-hidden">
    <div class="h-[420px] overflow-auto bg-slate-50 p-4 space-y-3">
      <div class="max-w-[78%] px-4 py-2 rounded-2xl border bg-white">こんにちは。ご相談内容をお聞かせください。</div>
      <div class="max-w-[78%] ml-auto px-4 py-2 rounded-2xl border bg-blue-50">見学の流れを知りたいです。</div>
      <div class="max-w-[78%] px-4 py-2 rounded-2xl border bg-white">承知しました。希望エリアなどありますか？</div>
    </div>

    <div class="border-t bg-white p-3 flex gap-2">
      <input class="flex-1 border rounded-xl px-3 py-2" placeholder="メッセージを入力（デモ）">
      <button class="px-5 py-2 rounded-xl bg-blue-600 text-white font-semibold hover:bg-blue-700" type="button">送信</button>
    </div>
  </div>
</div>
@endsection
