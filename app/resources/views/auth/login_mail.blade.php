@extends('layouts.app')
@section('title','ログイン')

@section('content')
<h1 class="fw-bold mb-3">ログイン</h1>

<div class="p-4 bg-white border rounded-4" style="max-width:720px; margin:auto;">
  <form method="POST" action="{{ route('login') }}" class="row g-3">
    @csrf

    <div class="col-12">
      <label class="form-label fw-semibold">メールアドレス</label>
      <input name="email" type="email" class="form-control" value="{{ old('email') }}" required>
      @error('email')
        <div class="text-danger small mt-1">{{ $message }}</div>
      @enderror
    </div>

    <div class="col-12">
      <label class="form-label fw-semibold">パスワード</label>
      <input name="password" type="password" class="form-control" required>
      @error('password')
        <div class="text-danger small mt-1">{{ $message }}</div>
      @enderror
    </div>

    <div class="col-12">
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="remember" id="remember" value="1">
        <label class="form-check-label" for="remember">ログイン状態を保持する</label>
      </div>
    </div>

    <div class="col-12 d-grid gap-2">
      <button class="btn btn-primary py-2">ログイン</button>
      <a class="btn btn-outline-secondary py-2" href="{{ route('signup') }}">会員登録へ</a>
    </div>
  </form>
</div>
@endsection
