@extends('layouts.app')
@section('title', 'お気に入り一覧')

@section('content')
<div class="container">

  <div class="border rounded-4 p-4 mb-4" style="background-color: LightYellow;">
    <h2 class="mb-0 fw-bold">お気に入り一覧</h2>
  </div>

  @if($properties->count() === 0)
    <div class="alert alert-secondary">
      お気に入りに登録された物件はまだありません。
    </div>
  @else
    <div class="row g-3">
      @foreach($properties as $property)
        @php
          $img = null;
          if ($property->relationLoaded('images') && $property->images && $property->images->count() > 0) {
            $img = $property->images->sortBy('sort_order')->first()->image_path;
          }
          $img = $img ?: "/images/dummy/property_1.JPG";
        @endphp

        <div class="col-12">
          <div class="card shadow-sm">
            <div class="row g-0">
              <div class="col-md-4">
                <img src="{{ $img }}" class="img-fluid rounded-start" style="object-fit:cover; height:200px; width:100%;" alt="物件画像">
              </div>
              <div class="col-md-8">
                <div class="card-body">
                  <h5 class="card-title fw-bold mb-2">{{ $property->title }}</h5>

                  <div class="text-secondary mb-2">
                    家賃：{{ number_format((int)$property->rent) }}円
                  </div>

                  <div class="small text-secondary mb-3">
                    住所：{{ $property->address ?? '—' }}
                  </div>

                  <div class="d-flex gap-2">
                    <a href="{{ route('properties.show', $property->id) }}" class="btn btn-primary btn-sm">
                      詳細を見る
                    </a>

                    {{-- 削除ボタン（destroyを作ってる前提） --}}
                    <form method="POST" action="{{ route('favorites.destroy', $property->id) }}"
                          onsubmit="return confirm('お気に入りを解除しますか？');">
                      @csrf
                      <button class="btn btn-outline-danger btn-sm">解除</button>
                    </form>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    <div class="mt-4">
      {{ $properties->links() }}
    </div>
  @endif

</div>
@endsection
