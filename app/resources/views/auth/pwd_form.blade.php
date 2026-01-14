@extends('layouts.app')

@section('content')
<div class="container py-5" style="max-width: 720px;">
  <div class="border rounded-4 p-4 bg-white">
    <h2 class="text-center mb-4">パスワード再設定</h2>

    {{-- ✅ 追加：全体エラーメッセージ表示 --}}
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
      @csrf

      <input type="hidden" name="token" value="{{ $token }}">
      <input type="hidden" name="email" value="{{ $email }}">

      <div class="mb-3">
        <label class="form-label">① 新しいパスワード入力</label>
        <input type="password"
               name="password"
               class="form-control @error('password') is-invalid @enderror"
               required>
        @error('password')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label class="form-label">② 新しいパスワード確認入力</label>
        <input type="password"
               name="password_confirmation"
               class="form-control"
               required>
      </div>

      <div class="text-center mt-4">
        <button type="submit" class="btn btn-outline-dark px-5">
          ③ 登録
        </button>
      </div>

    </form>
  </div>
</div>
@endsection
