@extends('layouts.app')
@section('title','会員情報編集')

@section('content')
<h1 class="fw-bold mb-3">会員情報編集</h1>

<div class="p-4 bg-white border rounded-4" style="max-width:720px; margin:auto;">
  <form method="POST" action="{{ route('mypage.update', 1) }}" class="row g-3">
    @csrf
    @method('PUT')

    <div class="col-12">
      <label class="form-label fw-semibold">メール</label>
      <input class="form-control" name="email" value="xxxxx@example.com">
    </div>

    <div class="col-12">
      <label class="form-label fw-semibold">お名前</label>
      <input class="form-control" name="name" value="xxxxx">
    </div>

    <div class="col-12">
      <label class="form-label fw-semibold">生年月日</label>
      <input class="form-control" type="date" name="dob" value="2000-01-01">
    </div>

    <div class="col-12 d-grid gap-2">
      <button class="btn btn-primary">保存（仮）</button>
      <a class="btn btn-outline-secondary" href="{{ route('user.info') }}">戻る</a>
    </div>
  </form>
</div>
@endsection
