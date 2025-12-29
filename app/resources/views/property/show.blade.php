@extends('layouts.app')
@section('title','物件詳細')

@section('content')
@php
  $p = [
    'id' => $id ?? 1001,
    'title' => 'サンプル物件A',
    'address' => '東京都〇〇区〇〇 1-2-3',
    'total' => 100000,
    'business' => '〇〇事業者',
  ];
@endphp

<div class="d-flex align-items-start justify-content-between gap-3">
  <div>
    <h1 class="fw-bold mb-1">物件詳細</h1>
    <div class="text-secondary">ID：{{ $p['id'] }}</div>
  </div>
  <a class="btn btn-outline-secondary" href="{{ route('properties.index') }}">一覧へ</a>
</div>

<div class="row g-3 mt-2">
  <div class="col-lg-8">
    <div class="p-4 bg-white border rounded-4">
      <h2 class="h4 fw-bold">{{ $p['title'] }}</h2>
      <div class="text-secondary mb-3">住所：{{ $p['address'] }}</div>

      <div class="border rounded-4 p-3 bg-light">
        <div class="fw-bold">支払合計金額</div>
        <div class="fs-3 fw-bold">{{ number_format($p['total']) }} 円</div>
      </div>

      <hr>

      <div class="fw-bold mb-2">基本情報</div>
      <div class="table-responsive">
        <table class="table table-bordered align-middle mb-0">
          <tbody>
            <tr><th class="bg-light" style="width:220px;">事業者名</th><td>{{ $p['business'] }}</td></tr>
            <tr><th class="bg-light">空室状況</th><td>空室あり</td></tr>
            <tr><th class="bg-light">定員</th><td>6名</td></tr>
            <tr><th class="bg-light">受入性別</th><td>男女可</td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="p-4 bg-white border rounded-4">
      <div class="fw-bold mb-3">アクション</div>
      <a class="btn btn-primary w-100 mb-2" href="{{ route('inquiries.create', $p['id']) }}">お問い合わせ</a>
      <a class="btn btn-outline-secondary w-100" href="{{ route('consultation.index') }}">LINE相談へ</a>
    </div>
  </div>
</div>
@endsection
