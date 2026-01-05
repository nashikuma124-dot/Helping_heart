@extends('layouts.app')
@section('title','検索結果一覧')

@section('content')
<h1 class="fw-bold mb-3">検索結果一覧</h1>

<div class="row g-3">

  {{-- 条件表示 --}}
  <div class="col-lg-4">
    <div class="p-4 border rounded-4" style="background-color: LightYellow;">
      <div class="fw-bold mb-2">検索条件</div>

      <div class="small text-secondary">
        <div>都道府県：{{ $areaName ?: '—' }}</div>

        <div>
          市区町村：
          {{ !empty($cityNames) ? implode(' / ', $cityNames) : '—' }}
        </div>

        <div>キーワード：{{ request('q') ?: '—' }}</div>

        <div class="mt-2">
          事業：
          {{ !empty($businessNames) ? implode(' / ', $businessNames) : '—' }}
        </div>

        <div>
          区分：
          {{ $disabilityName ?: '—' }}
        </div>

        <div>
          家賃：
          {{ request('rent_min') ?: '—' }} 〜 {{ request('rent_max') ?: '—' }}
        </div>

        <div>
          性別：
          {{ !empty($genderNames) ? implode(' / ', $genderNames) : '—' }}
        </div>

        <div>
          建物タイプ：
          {{ !empty($buildingNames) ? implode(' / ', $buildingNames) : '—' }}
        </div>

        <div>
          特徴：
          {{ !empty($featureNames) ? implode(' / ', $featureNames) : '—' }}
        </div>
      </div>

      @if((string)request('vacant_only') === '1')
        <div class="alert alert-info mt-3 mb-0">
          空室がある物件のみ表示中
        </div>
      @endif

      <a class="btn btn-outline-secondary w-100 mt-3" href="{{ route('property.search') }}">
        検索条件を変更
      </a>
    </div>
  </div>

  {{-- 結果表示 --}}
  <div class="col-lg-8">
    <div class="p-4 bg-white border rounded-4">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <div class="fw-bold">検索結果</div>
        <div class="text-secondary small">
          {{ $properties->total() }}件（{{ $properties->firstItem() ?? 0 }}〜{{ $properties->lastItem() ?? 0 }}件目）
        </div>
      </div>

      @if($properties->isEmpty())
        <div class="alert alert-warning mt-3">
          条件に一致する物件が見つかりませんでした。
        </div>
      @else
        <div class="d-flex flex-column gap-4 mt-3">

          @foreach($properties as $p)
            @php
              // 画像（property_imagesがある前提：無ければダミー）
              $img = optional($p->images->sortBy('sort_order')->first())->image_path
                     ?? '/images/dummy/property_1.jpg';

              // 受入性別（belongsTo想定：Property->gender）
              $genderName = $p->gender->name ?? '—';

              // 掲載日（created_at）
              $postedAt = $p->created_at ? $p->created_at->format('Y/m/d') : '—';
            @endphp

            <div class="border rounded-4 p-3 shadow-sm" style="background-color: LightYellow;">
              {{-- 上部：お気に入り + 掲載日 --}}
              <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                  @auth
                    <form method="POST" action="{{ route('favorites.store', $p->id) }}" class="d-inline">
                      @csrf
                      <button class="btn btn-outline-secondary btn-sm" type="submit">お気に入り登録☆</button>
                    </form>
                  @else
                    <a class="btn btn-outline-secondary btn-sm" href="{{ route('login') }}">お気に入り登録☆</a>
                  @endauth
                </div>

                <div class="text-secondary small">
                  掲載日：{{ $postedAt }}
                </div>
              </div>

              {{-- 画像2枚風（同じ画像を2枚表示） --}}
              <div class="row g-3 mb-3">
                <div class="col-6">
                  <div class="ratio ratio-4x3 border rounded-3 overflow-hidden bg-light">
                    <img src="{{ $img }}" alt="物件画像" class="w-100 h-100" style="object-fit: cover;">
                  </div>
                </div>
                <div class="col-6">
                  <div class="ratio ratio-4x3 border rounded-3 overflow-hidden bg-light">
                    <img src="{{ $img }}" alt="物件画像" class="w-100 h-100" style="object-fit: cover;">
                  </div>
                </div>
              </div>

              {{-- 物件名（クリックで詳細。青リンクにしない） --}}
              <div class="text-center mb-2">
                <a href="{{ route('properties.show', $p->id) }}"
                   class="d-inline-block px-3 py-2 rounded text-white fw-bold text-decoration-none"
                   style="background-color: #ff9800;">
                  {{ $p->title }}
                </a>
              </div>

              {{-- 住所 --}}
              <div class="text-center fw-semibold mb-1">住所</div>
              <div class="text-center text-secondary mb-2">{{ $p->address }}</div>

              {{-- 最寄り駅（DB） --}}
              <div class="text-center fw-semibold mb-3 text-dark">
                最寄り駅名：
                {{ $p->nearest_station ?: '—' }}
                @if(!is_null($p->walk_minutes))
                  徒歩{{ (int)$p->walk_minutes }}分
                @endif
              </div>

              {{-- 説明 --}}
              <div class="small text-secondary border rounded-3 p-2 mb-3 bg-white">
                {{ \Illuminate\Support\Str::limit($p->description ?? '物件について簡単な説明', 80) }}
              </div>

              {{-- 4分割情報（表） --}}
              <div class="border rounded-3 overflow-hidden bg-white">
                <div class="row g-0">
                  <div class="col-6 border-end border-bottom p-2">
                    <div class="small text-secondary">家賃</div>
                    <div class="fw-bold">{{ number_format((int)$p->rent) }}円</div>
                  </div>
                  <div class="col-6 border-bottom p-2">
                    <div class="small text-secondary">受入性別</div>
                    <div class="fw-bold">{{ $genderName }}</div>
                  </div>
                  <div class="col-6 border-end p-2">
                    <div class="small text-secondary">支払総計</div>
                    <div class="fw-bold">{{ number_format((int)$p->total) }}円</div>
                  </div>
                  <div class="col-6 p-2">
                    <div class="small text-secondary">定員</div>
                    <div class="fw-bold">{{ (int)$p->capacity }}名</div>
                  </div>
                </div>

                <div class="border-top p-2">
                  <div class="small text-secondary">空室状況</div>
                  <div class="fw-bold text-dark">
                    {{ (int)$p->availability === 1 ? 'あり' : 'なし' }}
                  </div>
                </div>
              </div>

              {{-- 詳細ボタン（オレンジ） --}}
              <div class="text-center mt-3">
                <a class="btn px-4 text-white"
                   style="background-color:#ff9800;"
                   href="{{ route('properties.show', $p->id) }}">
                  詳細はこちら
                </a>
              </div>

            </div>
          @endforeach

        </div>

        {{-- GET条件保持のページ送り --}}
        <div class="mt-4">
          {{ $properties->appends(request()->query())->links() }}
        </div>
      @endif

    </div>
  </div>

</div>
@endsection
