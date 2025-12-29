@extends('layouts.app')
@section('title','物件一覧')

@section('content')
<h1 class="fw-bold mb-3">物件一覧</h1>

<div class="row g-3">
  @php
    $items = [
      ['id'=>1001,'title'=>'サンプル物件A','meta'=>'東京都〇〇区 / 空室あり'],
      ['id'=>1002,'title'=>'サンプル物件B','meta'=>'大阪府〇〇市 / 空室なし'],
      ['id'=>1003,'title'=>'サンプル物件C','meta'=>'神奈川県〇〇市 / 空室あり'],
    ];
  @endphp

  @foreach($items as $p)
    <div class="col-md-4">
      <div class="card h-100">
        <div class="card-body">
          <h5 class="card-title fw-bold">{{ $p['title'] }}</h5>
          <p class="card-text text-secondary">{{ $p['meta'] }}</p>
          <a class="btn btn-primary" href="{{ route('properties.show', $p['id']) }}">詳細</a>
        </div>
      </div>
    </div>
  @endforeach
</div>
@endsection
