@extends('layouts.app')
@section('title','チャット相談窓口')

@section('content')
<h1 class="fw-bold mb-3">チャット相談窓口</h1>

<div class="row g-3">
  <div class="col-md-6">
    <div class="p-4 bg-white border rounded-4 h-100">
      <h2 class="h5 fw-bold">グループホーム相談</h2>
      <p class="text-secondary mb-3">LINE 友達追加 → チャット開始</p>
      <a class="btn btn-primary w-100" href="{{ route('consultation.home') }}">友達追加へ</a>
    </div>
  </div>

  <div class="col-md-6">
    <div class="p-4 bg-white border rounded-4 h-100">
      <h2 class="h5 fw-bold">福祉サービス相談</h2>
      <p class="text-secondary mb-3">LINE 友達追加 → チャット開始</p>
      <a class="btn btn-primary w-100" href="{{ route('consultation.welfare') }}">友達追加へ</a>
    </div>
  </div>
</div>
@endsection
