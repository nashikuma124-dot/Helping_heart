@extends('layouts.app')
@section('title','お問い合わせ')

@section('content')
<div class="mx-auto p-4 border rounded-4 bg-white" style="max-width: 720px;">
  <h1 class="fw-bold mb-4">お問い合わせ</h1>

  <form method="POST" action="{{ route('inquiries.confirm') }}">
    @csrf

    {{-- 物件ID --}}
    <input type="hidden" name="property_id" value="{{ $property->id }}">

    {{-- 1. お問い合わせ内容 --}}
    <div class="mb-3">
      <div class="fw-bold mb-2">1. お問い合わせ内容</div>

      @php
        $type = old('inquiry_type', $form['inquiry_type'] ?? 'plan');
      @endphp

      <div class="form-check mb-1">
        <input class="form-check-input" type="radio" name="inquiry_type" id="type_plan"
               value="plan" {{ $type === 'plan' ? 'checked' : '' }}>
        <label class="form-check-label" for="type_plan">プランや料金の詳細を知りたい</label>
      </div>

      <div class="form-check mb-1">
        <input class="form-check-input" type="radio" name="inquiry_type" id="type_tour"
               value="tour" {{ $type === 'tour' ? 'checked' : '' }}>
        <label class="form-check-label" for="type_tour">見学を希望したい</label>
      </div>

      <div class="form-check">
        <input class="form-check-input" type="radio" name="inquiry_type" id="type_other"
               value="other" {{ $type === 'other' ? 'checked' : '' }}>
        <label class="form-check-label" for="type_other">その他のお問い合わせ</label>
      </div>

      @error('inquiry_type')
        <div class="text-danger small mt-1">{{ $message }}</div>
      @enderror
    </div>

    {{-- 詳細内容（other の時だけ必須） --}}
    <div class="mb-4">
      <label class="fw-bold mb-2 d-block">
        詳細内容 <span class="text-secondary fw-normal">（「その他」の場合は必須）</span>
      </label>

      <textarea id="detailMessage" name="message" class="form-control" rows="6"
                placeholder="詳細内容を記入">{{ old('message', $form['message'] ?? '') }}</textarea>

      <div id="detailHelp" class="form-text">
        「その他のお問い合わせ」を選んだ場合は必ず入力してください。
      </div>

      @error('message')
        <div class="text-danger small mt-1">{{ $message }}</div>
      @enderror
    </div>

    {{-- 2. お名前 --}}
    <div class="mb-3">
      <label class="fw-bold mb-2 d-block">2. お名前</label>
      <input type="text" name="name" class="form-control"
             value="{{ old('name', $form['name'] ?? '') }}">
      @error('name')
        <div class="text-danger small mt-1">{{ $message }}</div>
      @enderror
    </div>

    {{-- 3. メールアドレス --}}
    <div class="mb-3">
      <label class="fw-bold mb-2 d-block">3. メールアドレス</label>
      <input type="email" name="email" class="form-control"
             value="{{ old('email', $form['email'] ?? '') }}">
      @error('email')
        <div class="text-danger small mt-1">{{ $message }}</div>
      @enderror
    </div>

    {{-- 4. 電話番号 --}}
    <div class="mb-4">
      <label class="fw-bold mb-2 d-block">4. 電話番号</label>
      <input type="text" name="tel" class="form-control"
             value="{{ old('tel', $form['tel'] ?? '') }}">
      @error('tel')
        <div class="text-danger small mt-1">{{ $message }}</div>
      @enderror
    </div>

    <button class="btn btn-primary w-100 py-2">確認画面へ</button>
  </form>
</div>

<script>
  function syncDetailRequired() {
    const other = document.getElementById('type_other');
    const detail = document.getElementById('detailMessage');
    if (!other || !detail) return;
    detail.required = other.checked;
  }

  document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('input[name="inquiry_type"]').forEach(el => {
      el.addEventListener('change', syncDetailRequired);
    });
    syncDetailRequired();
  });
</script>
@endsection
