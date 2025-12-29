@extends('layouts.app')
@section('title','マイページ')

@section('content')
<h1 class="fw-bold mb-3">マイページ</h1>

<div class="p-4 bg-white border rounded-4">
  <div class="row g-3">
    <div class="col-md-6"><a class="btn btn-primary w-100 py-3" href="{{ route('properties.index') }}">① 物件一覧</a></div>
    <div class="col-md-6"><a class="btn btn-primary w-100 py-3" href="{{ route('favorites.index') }}">② お気に入り</a></div>
    <div class="col-md-6"><a class="btn btn-outline-secondary w-100 py-3" href="{{ route('consultation.index') }}">③ 相談</a></div>
    <div class="col-md-6"><a class="btn btn-outline-secondary w-100 py-3" href="{{ route('user.info') }}">④ 会員情報</a></div>
  </div>
</div>
@endsection
