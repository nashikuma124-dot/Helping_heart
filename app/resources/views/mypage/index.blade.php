@extends('layouts.app')
@section('title','マイページ')

@section('content')
<div class="mx-auto" style="max-width: 900px;">

  <h1 class="fw-bold mb-4">マイページ</h1>

  <div class="p-5 bg-white border rounded-4">
    <div class="d-flex justify-content-center">
      <div class="d-grid gap-4" style="grid-template-columns: 260px 260px; display:grid;">

        {{-- ① 物件検索 → 検索画面へ --}}
        <a href="{{ route('property.search') }}"
           class="btn btn-outline-secondary py-4 fw-bold rounded-3"
           style="border-width:2px;">
          ①物件検索
        </a>

        {{-- ② お気に入り物件一覧 --}}
        <a href="{{ route('favorites.index') }}"
           class="btn btn-outline-secondary py-4 fw-bold rounded-3"
           style="border-width:2px;">
          ②お気に入り物件<br>一覧
        </a>

        {{-- ③ LINE相談案内 --}}
        <a href="{{ route('consultation.home') }}"
           class="btn btn-outline-secondary py-4 fw-bold rounded-3"
           style="border-width:2px;">
          ③LINE相談案内
        </a>

        {{-- ④ 会員情報 --}}
        <a href="{{ route('user.info') }}"
           class="btn btn-outline-secondary py-4 fw-bold rounded-3"
           style="border-width:2px;">
          ④会員情報
        </a>

      </div>
    </div>
  </div>
</div>
@endsection
