@extends('layouts.app')
@section('title','グループホーム相談（LINE友達追加）')

@section('content')
<h1 class="fw-bold mb-3">グループホーム相談（LINE友達追加）</h1>

<div class="p-4 bg-white border rounded-4 text-center">
  <div class="border rounded-4 bg-light d-flex align-items-center justify-content-center"
       style="height:180px;">
    <div class="text-secondary fw-bold">QRコード / 友達追加導線（想定）</div>
  </div>

  <p class="text-secondary mt-3 mb-0">友達追加が完了したら、下のボタンからチャットを開始します。</p>

  <a class="btn btn-primary mt-3" href="{{ route('consultation.home.chat') }}">チャット開始</a>
</div>
@endsection
