@extends('layouts.app')
@section('title','お問い合わせ')

@section('content')
<h1 class="fw-bold mb-3">お問い合わせ</h1>

<div class="p-4 bg-white border rounded-4">
  <div class="text-secondary mb-3">問い合わせ物件ID：{{ $property_id ?? $property ?? '' }}</div>

  <form method="POST" action="{{ route('inquiries.confirm') }}" class="row g-3">
    @csrf
    <input type="hidden" name="property_id" value="{{ $property_id ?? $property ?? '' }}">

    <div class="col-12">
      <label class="form-label fw-semibold">1. お問い合わせ内容</label>
      <div class="d-flex flex-column gap-2">
        <div class="form-check">
          <input class="form-check-input" type="radio" name="type" value="plan" checked>
          <label class="form-check-label">プランや料金の詳細を知りたい</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="type" value="visit">
          <label class="form-check-label">見学を希望したい</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="type" value="other">
          <label class="form-check-label">その他のお問い合わせ</label>
        </div>
      </div>
    </div>

    <div class="col-12">
      <label class="form-label fw-semibold">詳細内容（任意）</label>
      <textarea class="form-control" name="content" rows="4" placeholder="詳細内容を記入"></textarea>
    </div>

    <div class="col-md-6">
      <label class="form-label fw-semibold">2. お名前</label>
      <input class="form-control" name="name" required>
    </div>

    <div class="col-md-6">
      <label class="form-label fw-semibold">3. メールアドレス</label>
      <input class="form-control" type="email" name="email" required>
    </div>

    <div class="col-md-6">
      <label class="form-label fw-semibold">4. 電話番号</label>
      <input class="form-control" name="tel">
    </div>

    <div class="col-12">
      <button class="btn btn-primary w-100 py-2">確認画面へ</button>
    </div>
  </form>
</div>
@endsection
