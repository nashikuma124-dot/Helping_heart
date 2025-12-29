@extends('layouts.app')
@section('title','会員情報')

@section('content')
<h1 class="fw-bold mb-3">会員情報</h1>

<div class="p-4 bg-white border rounded-4" style="max-width:720px; margin:auto;">
  <table class="table table-bordered align-middle mb-0">
    <tbody>
      <tr><th class="bg-light" style="width:220px;">メール</th><td>xxxxx@example.com</td></tr>
      <tr><th class="bg-light">お名前</th><td>xxxxx</td></tr>
      <tr><th class="bg-light">生年月日</th><td>xxxx-xx-xx</td></tr>
    </tbody>
  </table>

  <div class="d-grid gap-2 mt-3">
    <a class="btn btn-primary" href="{{ route('mypage.edit', 1) }}">会員情報を変更する</a>

    <form method="POST" action="{{ route('user.delete') }}">
      @csrf
      <button class="btn btn-outline-danger" type="submit">退会（仮）</button>
    </form>
  </div>
</div>
@endsection
