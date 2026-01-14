@extends('layouts.app')
@section('title','会員情報 編集内容確認')

@section('content')
@php
  $data = session('mypage_edit', []);
  $pwMask = '********';
@endphp

<div class="container">

  <div class="border rounded-4 p-4 mb-4 bg-white">
    <div class="text-center fw-bold fs-4 mb-2">会員情報</div>
    <div class="text-center fw-bold fs-5 mb-4">編集内容確認</div>

    <div class="d-flex justify-content-center">
      <table class="table table-bordered" style="max-width:520px;">
        <tbody>
          <tr>
            <th style="width:40%;">メールアドレス</th>
            <td>{{ $data['email'] ?? '' }}</td>
          </tr>
          <tr>
            <th>パスワード</th>
            <td>{{ !empty($data['has_password']) ? $pwMask : '' }}</td>
          </tr>
          <tr>
            <th>お名前</th>
            <td>{{ $data['name'] ?? '' }}</td>
          </tr>
          <tr>
            <th>生年月日</th>
            <td>{{ $data['dob'] ?? '' }}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="d-flex justify-content-center gap-3 mt-4">
      {{-- ① 編集画面へ（入力は session に残ってる想定） --}}
      <a class="btn btn-outline-secondary px-5" href="{{ route('mypage.edit', auth()->id()) }}">
        ① 編集画面へ
      </a>

      {{-- ② 登録（POST /mypage/update） --}}
      <form method="POST" action="{{ route('mypage.update') }}">
  @csrf
  
  <button type="submit" class="btn btn-primary px-5">② 登録</button>
</form>

    </div>
  </div>

</div>
@endsection
