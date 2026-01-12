@extends('layouts.app')
@section('title','会員情報 編集内容確認')

@section('content')
@php
  // Controller から渡される想定：$data = ['email','name','dob','has_password']
  $pwMask = '********';
@endphp

<div class="container">

  <div class="border rounded-4 p-4 mb-4" style="background-color: #fff;">
    <div class="text-center fw-bold fs-4 mb-3">会員情報</div>
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

      {{-- ① 編集画面へ戻る（セッションは残ってるので、そのまま戻ってOK） --}}
      <a href="{{ route('mypage.edit', 1) }}" class="btn btn-outline-secondary px-5">
        ① 編集画面へ
      </a>

      {{-- ② 登録（✅ POSTで更新：セッションmypage_editで更新する） --}}
      <form method="POST" action="{{ route('mypage.update') }}">
        @csrf
        <button class="btn btn-primary px-5">② 登録</button>
      </form>

    </div>
  </div>

</div>
@endsection
