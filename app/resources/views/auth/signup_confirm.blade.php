@extends('layouts.app')
@section('title','会員登録確認')

@section('content')
<h1 class="fw-bold mb-3">会員登録 入力内容確認</h1>

@php
  // Controllerで session('signup') に入れている想定
  $signup = session('signup', []);
  $email = $signup['email'] ?? '';
  $name  = $signup['name'] ?? '';
  $dob   = $signup['dob'] ?? '';
@endphp

<div class="p-4 bg-white border rounded-4" style="max-width:720px; margin:auto;">
  <div class="table-responsive">
    <table class="table table-bordered align-middle mb-0">
      <tbody>
        <tr>
          <th class="bg-light" style="width:220px;">メールアドレス</th>
          <td>{{ $email }}</td>
        </tr>
        <tr>
          <th class="bg-light">パスワード</th>
          <td>********</td>
        </tr>
        <tr>
          <th class="bg-light">お名前</th>
          <td>{{ $name }}</td>
        </tr>
        <tr>
          <th class="bg-light">生年月日</th>
          <td>{{ $dob }}</td>
        </tr>
      </tbody>
    </table>
  </div>

  <div class="d-flex flex-wrap gap-2 justify-content-center mt-3">

    {{-- ✅ 入力画面へ戻る（入力保持） --}}
    <form method="POST" action="{{ route('signup.back') }}" class="d-inline">
        @csrf
        <input type="hidden" name="email" value="{{ $email }}">
        <input type="hidden" name="name" value="{{ $name }}">
        <input type="hidden" name="dob" value="{{ $dob }}">
        <button type="submit" class="btn btn-outline-secondary">入力に戻る</button>
    </form>


    {{-- ✅ 登録（sessionの内容で登録する。passwordをhiddenで渡さない） --}}
    <form method="POST" action="{{ route('signup.complete') }}">
        @csrf
        <!-- hiddenたち -->
        <button class="btn btn-primary">登録</button>
    </form>


  </div>
</div>
@endsection
