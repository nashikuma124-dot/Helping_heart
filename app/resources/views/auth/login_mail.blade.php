@extends('layouts.app')
@section('title','ログイン（e-mail）')

@section('content')
<h1 class="fw-bold mb-3">ログイン</h1>

<div class="p-4 bg-white border rounded-4" style="max-width:720px; margin:auto;">
  <form method="POST" action="{{ route('login') }}" class="row g-3">
    @csrf

    <div class="col-12">
      <label class="form-label fw-semibold">メールアドレス</label>
      <input class="form-control" type="email" name="email" required>
    </div>

    <div class="col-12">
      <label class="form-label fw-semibold">パスワード</label>
      <input class="form-control" type="password" name="password" required>
    </div>

    <div class="col-12">
      <a class="text-decoration-none" href="{{ route('password.request') }}">パスワードを忘れた方はこちら</a>
    </div>

    <div class="col-12 d-grid gap-2">
      <button class="btn btn-primary py-2">ログイン</button>
      <a class="btn btn-outline-secondary py-2" href="{{ route('line.login') }}">LINEでログイン</a>
    </div>
  </form>
</div>
@endsection
