@extends('layouts.app')

@section('title', 'パスワード再設定完了')

@section('content')
<div class="container">
  <div class="border rounded-4 p-4 mb-4 bg-white text-center">

    <div class="mb-5">
      <h4>パスワード再設定が完了しました</h4>
    </div>

    <div>
      <a href="{{ route('login') }}" class="btn btn-outline-dark px-5">
        ① ログイン画面へ戻る
      </a>
    </div>

  </div>
</div>
@endsection
