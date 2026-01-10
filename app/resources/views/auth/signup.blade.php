@extends('layouts.app')
@section('title','会員登録')

@section('content')
<h1 class="fw-bold mb-3">会員登録</h1>

<div class="p-4 bg-white border rounded-4" style="max-width:720px; margin:auto;">
  <form method="POST" action="{{ route('signup.confirm') }}" class="row g-3">
    @csrf

    <div class="col-12">
      <label class="form-label fw-semibold">メールアドレス</label>
      <input name="email" type="email" class="form-control"
             value="{{ old('email') }}"
             placeholder="メールアドレス入力" required>
      @error('email')
        <div class="text-danger small mt-1">{{ $message }}</div>
      @enderror
    </div>

    <div class="col-12">
      <label class="form-label fw-semibold">パスワード</label>
      <input name="password" type="password" class="form-control"
             placeholder="英数字6文字以上" required>
      @error('password')
        <div class="text-danger small mt-1">{{ $message }}</div>
      @enderror
    </div>

    <div class="col-12">
      <label class="form-label fw-semibold">パスワード確認</label>
      <input name="password_confirmation" type="password" class="form-control"
             placeholder="確認入力" required>
    </div>

    <div class="col-12">
      <label class="form-label fw-semibold">お名前</label>
      <input name="name" class="form-control"
             value="{{ old('name') }}"
             placeholder="名前入力" required>
      @error('name')
        <div class="text-danger small mt-1">{{ $message }}</div>
      @enderror
    </div>

    <div class="col-12">
      <label class="form-label fw-semibold">生年月日</label>
      <input name="dob" type="date" class="form-control"
             value="{{ old('dob') }}"
             required>
      @error('dob')
        <div class="text-danger small mt-1">{{ $message }}</div>
      @enderror
    </div>

    <div class="col-12 d-grid gap-2">
      <button type="submit" class="btn btn-primary py-2">確認画面へ</button>
      <a class="btn btn-outline-secondary py-2" href="{{ route('login') }}">ログインへ</a>
    </div>
  </form>
</div>
@endsection
