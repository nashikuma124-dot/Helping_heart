@extends('layouts.app')
@section('title','LINEログインエラー')

@section('content')
<div class="p-5 bg-white border rounded-4 text-center" style="max-width:720px; margin:auto;">
  <h1 class="fw-bold text-danger">LINEログインに失敗しました</h1>
  <p class="text-secondary mt-3">
    LINE認証中にエラーが発生しました。<br>
    もう一度ログインをお試しください。
  </p>

  <a href="{{ route('login') }}" class="btn btn-primary mt-3">ログイン画面へ戻る</a>
</div>
@endsection
