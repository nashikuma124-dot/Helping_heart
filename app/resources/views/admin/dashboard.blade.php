@extends('layouts.app')
@section('title','管理者ページ')

@section('content')
<h1 class="fw-bold mb-3">管理者ページ</h1>

<div class="p-4 bg-white border rounded-4">
  <div class="row g-3">
    <div class="col-md-4">
      <a class="btn btn-primary w-100 py-3" href="{{ route('admin.properties.index') }}">物件データ管理</a>
    </div>
    <div class="col-md-4">
      <a class="btn btn-primary w-100 py-3" href="{{ route('admin.users.index') }}">会員ユーザー管理</a>
    </div>
    <div class="col-md-4">
      <a class="btn btn-primary w-100 py-3" href="{{ route('admin.inquiries.index') }}">ユーザー問い合わせ管理</a>
    </div>

    <div class="col-md-6">
      <a class="btn btn-outline-secondary w-100 py-3" href="{{ route('top') }}">トップへ</a>
    </div>
    <div class="col-md-6">
      <a class="btn btn-outline-secondary w-100 py-3" href="{{ route('error') }}">エラー画面（例）</a>
    </div>
  </div>
</div>
@endsection
