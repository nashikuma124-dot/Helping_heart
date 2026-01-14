@extends('layouts.app')

@section('content')
<div class="container py-5" style="max-width: 720px;">
  <div class="border rounded-4 p-4 bg-white">
    <p class="mb-3">※メールアドレスに送られたURLからアクセス</p>

    <h2 class="text-center mb-4">パスワード再設定</h2>

    @if (session('status'))
      <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
      @csrf

      <div class="mb-3">
        <label class="form-label">メールアドレス</label>
        <input type="email"
               name="email"
               class="form-control @error('email') is-invalid @enderror"
               value="{{ old('email') }}"
               required>
        @error('email')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="text-center mt-4">
        <button type="submit" class="btn btn-outline-dark px-5">
          ② メール送信
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
