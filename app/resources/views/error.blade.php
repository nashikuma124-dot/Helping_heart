@extends('layouts.app')
@section('title','エラー')

@section('content')
<div class="p-5 bg-white border rounded-4 text-center" style="max-width:720px; margin:auto;">
  <h1 class="fw-bold">エラーが発生しました</h1>
  <p class="text-secondary mt-2">お手数ですが、時間をおいて再度お試しください。</p>

  <div class="d-flex flex-wrap justify-content-center gap-2 mt-3">
    <a class="btn btn-primary" href="{{ route('top') }}">トップへ</a>
    <a class="btn btn-outline-secondary" href="javascript:history.back()">戻る</a>
  </div>
</div>
@endsection
