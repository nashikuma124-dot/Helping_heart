@extends('layouts.app')
@section('title','会員情報 削除確認')

@section('content')
@php
  $pwMask = '********';
  // DOBカラム名が環境で違っても表示できるように保険
  $dob = $user->dob ?? ($user->dateofbirth ?? '');
@endphp

<div class="container py-4">

  <div class="bg-white border rounded-4 p-4 mx-auto" style="max-width: 760px;">
    <div class="text-center fw-bold fs-4 mb-2">会員情報</div>

    <div class="text-center text-danger fw-bold mb-4">
      本当に会員情報を削除してもよろしいですか？
    </div>

    <div class="d-flex justify-content-center">
      <table class="table table-bordered align-middle" style="max-width: 520px; width:100%;">
        <tbody>
          <tr>
            <th style="width:40%;" class="bg-light">メールアドレス</th>
            <td>{{ $user->email }}</td>
          </tr>
          <tr>
            <th class="bg-light">パスワード</th>
            <td>{{ $pwMask }}</td>
          </tr>
          <tr>
            <th class="bg-light">お名前</th>
            <td>{{ $user->name }}</td>
          </tr>
          <tr>
            <th class="bg-light">生年月日</th>
            <td>{{ $dob }}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="d-flex justify-content-center gap-3 mt-4">
      {{-- ① 削除する（POSTで実行） --}}
      <form method="POST" action="{{ route('user.delete') }}">
        @csrf
        <button type="submit" class="btn btn-outline-dark px-5"
          onclick="return confirm('本当に削除しますか？');">
          ① 削除する
        </button>
      </form>

      {{-- ② 編集画面へ戻る --}}
      <a class="btn btn-outline-secondary px-5" href="{{ route('mypage.edit', auth()->id()) }}">
        ② 編集画面へ戻る
      </a>
    </div>

  </div>
</div>
@endsection
