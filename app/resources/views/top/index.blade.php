@extends('layouts.app')

@section('title', 'トップ')

@section('content')
<div
  class="min-vh-100 d-flex align-items-center justify-content-center"
  style="
    background-image: url('{{ asset('images/top_forest_bg.png') }}');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
  "
>
  {{-- オーバーレイ --}}
  <div class="bg-white bg-opacity-75 rounded-4 shadow p-5 text-center" style="max-width: 600px; width: 100%;">
    <h1 class="fw-bold mb-3">Helping Heart</h1>
    <p class="text-muted mb-4">
      福祉グループホーム・住まい探しと相談の窓口
    </p>

    <div class="d-grid gap-3">
      <a href="{{ route('property.search') }}" class="btn btn-warning btn-lg">
        物件検索
      </a>


      <a href="{{ route('consultation.index') }}" class="btn btn-outline-secondary btn-lg">
        LINE相談
      </a>

      <a href="{{ route('signup') }}" class="btn btn-outline-primary">
        会員登録
      </a>

      <a href="{{ route('login') }}" class="btn btn-outline-dark">
        ログイン
      </a>
    </div>
  </div>
</div>
@endsection
{{-- 確認用 --}}
<div style="position:fixed;top:0;left:0;background:red;color:white;z-index:9999;">
  TOP VIEW
</div>

