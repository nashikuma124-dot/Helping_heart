@extends('layouts.app')
@section('title','お問い合わせ確認')

@section('content')
<h1 class="fw-bold mb-3">お問い合わせ内容確認</h1>

@php
  $type = old('type', request('type','plan'));
  $propertyId = old('property_id', request('property_id',''));
@endphp

<div class="p-4 bg-white border rounded-4">
  <div class="table-responsive">
    <table class="table table-bordered align-middle">
      <tbody>
        <tr><th class="bg-light" style="width:220px;">物件ID</th><td>{{ $propertyId }}</td></tr>
        <tr><th class="bg-light">お問い合わせ内容</th><td>{{ $type }}</td></tr>
        <tr><th class="bg-light">お名前</th><td>{{ old('name', request('name','')) }}</td></tr>
        <tr><th class="bg-light">メール</th><td>{{ old('email', request('email','')) }}</td></tr>
        <tr><th class="bg-light">電話</th><td>{{ old('tel', request('tel','')) }}</td></tr>
        <tr><th class="bg-light">詳細</th><td>{{ old('content', request('content','')) }}</td></tr>
      </tbody>
    </table>
  </div>

  <div class="d-flex flex-wrap gap-2 justify-content-center">
    <a class="btn btn-outline-secondary" href="{{ url()->previous() }}">入力に戻る</a>

    <form method="POST" action="{{ route('inquiries.store') }}">
      @csrf
      <input type="hidden" name="property_id" value="{{ $propertyId }}">
      <input type="hidden" name="type" value="{{ $type }}">
      <input type="hidden" name="name" value="{{ old('name', request('name','')) }}">
      <input type="hidden" name="email" value="{{ old('email', request('email','')) }}">
      <input type="hidden" name="tel" value="{{ old('tel', request('tel','')) }}">
      <input type="hidden" name="content" value="{{ old('content', request('content','')) }}">
      <button class="btn btn-primary">送信</button>
    </form>
  </div>
</div>
@endsection
