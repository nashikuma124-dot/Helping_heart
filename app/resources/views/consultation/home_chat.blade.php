@extends('layouts.app')
@section('title','グループホーム相談（チャット）')

@section('content')
<h1 class="fw-bold mb-3">グループホーム相談（チャット）</h1>

<div class="p-4 bg-white border rounded-4">
  <div class="border rounded-4 overflow-hidden">
    <div class="p-3 bg-light" style="height:420px; overflow:auto;">
      <div class="d-flex flex-column gap-2">
        <div class="p-2 bg-white border rounded-3" style="max-width:78%;">こんにちは。ご相談内容をお聞かせください。</div>
        <div class="p-2 bg-primary bg-opacity-10 border rounded-3 ms-auto" style="max-width:78%;">見学の流れを知りたいです。</div>
        <div class="p-2 bg-white border rounded-3" style="max-width:78%;">承知しました。希望エリアなどありますか？</div>
      </div>
    </div>

    <div class="border-top p-3 bg-white d-flex gap-2">
      <input class="form-control" placeholder="メッセージを入力（デモ）">
      <button class="btn btn-primary" type="button">送信</button>
    </div>
  </div>
</div>
@endsection
