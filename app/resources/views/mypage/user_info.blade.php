@extends('layouts.app')
@section('title','会員情報')

@section('content')
@php
  $u = auth()->user();

  // パスワードは実物を出さないので、常に伏字
  $pwMask = '********';

  // LINEログインでダミーメール or 未登録なら空欄表示
  $isLineUser = !empty($u->line_id);
  $emailIsDummy = $u->email
    && str_starts_with($u->email, 'line_')
    && str_ends_with($u->email, '@example.local');

  $emailView = ($isLineUser && (!$u->email || $emailIsDummy)) ? '' : ($u->email ?? '');
@endphp

<h1 class="fw-bold mb-4 text-center">会員情報</h1>

<div class="p-4 bg-white border rounded-4" style="max-width:720px; margin:auto;">
  <table class="table table-bordered align-middle text-center">
    <tr>
      <th class="bg-light">メールアドレス</th>
      <td>{{ $emailView !== '' ? $emailView : '—' }}</td>
    </tr>
    <tr>
      <th class="bg-light">パスワード</th>
      <td>{{ $pwMask }}</td>
    </tr>
    <tr>
      <th class="bg-light">お名前</th>
      <td>{{ $u->name }}</td>
    </tr>
    <tr>
      <th class="bg-light">生年月日</th>
      <td>{{ $u->dob ? $u->dob : '—' }}</td>
    </tr>
  </table>

  <div class="text-center mt-4">
   <a href="{{ route('mypage.edit', auth()->id()) }}"
    class="btn btn-primary">
    変更する
   </a>

  </div>
</div>
@endsection
