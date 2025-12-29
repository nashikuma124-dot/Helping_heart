@extends('layouts.app')
@section('title','お気に入り')

@section('content')
<h1 class="fw-bold mb-3">お気に入り</h1>

<div class="row g-3">
  @php
    $items = [
      ['id'=>1001,'title'=>'サンプル物件A','meta'=>'東京都〇〇区 / 空室あり'],
      ['id'=>1002,'title'=>'サンプル物件B','meta'=>'大阪府〇〇市 / 空室なし'],
    ];
  @endphp

  @foreach($items as $p)
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <div class="fw-bold">{{ $p['title'] }}</div>
          <div class="text-secondary">{{ $p['meta'] }}</div>

          <div class="d-flex gap-2 mt-3">
            <a class="btn btn-primary" href="{{ route('properties.show', $p['id']) }}">詳細</a>
            <form method="POST" action="{{ route('favorites.destroy', $p['id']) }}">
              @csrf
              @method('DELETE')
              <button class="btn btn-outline-secondary" type="submit">解除</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  @endforeach
</div>
@endsection
