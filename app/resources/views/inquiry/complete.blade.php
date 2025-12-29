@extends('layouts.app')
@section('title','お問い合わせ完了')

@section('content')
<div class="p-5 bg-white border rounded-4 text-center">
  <h1 class="fw-bold">お問い合わせが完了しました</h1>
  <p class="text-secondary mt-2">担当者からご連絡いたしますので、しばらくお待ちください。</p>
  <a class="btn btn-primary mt-3" href="{{ route('top') }}">トップへ戻る</a>
</div>
@endsection
