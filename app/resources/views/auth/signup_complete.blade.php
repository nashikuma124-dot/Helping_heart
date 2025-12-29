@extends('layouts.app')
@section('title','会員登録完了')

@section('content')
<div class="p-5 bg-white border rounded-4 text-center" style="max-width:720px; margin:auto;">
  <h1 class="fw-bold">会員登録が完了しました。</h1>
  <p class="text-secondary mt-2">ログインしてサービスをご利用ください。</p>

  <a class="btn btn-primary mt-3" href="{{ route('login') }}">ログイン画面へ</a>
</div>
@endsection
