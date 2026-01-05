@extends('layouts.app')
@section('title', '物件詳細')

@section('content')
@php
  // 画像（property_imagesがある前提：無ければダミー）
  $images = $property->images ? $property->images : collect();
  $images = $images->sortBy('sort_order')->values();

  $mainImg = optional($images->first())->image_path ?: '/images/dummy/property_1.jpg';

  // 掲載日
  $postedAt = $property->created_at ? $property->created_at->format('Y/m/d') : '—';

  // タグ（設計書のボタン群）
  $businessNames = $property->businessTypes ? $property->businessTypes->pluck('name')->filter()->values() : collect();
  $buildingNames = $property->buildingTypes ? $property->buildingTypes->pluck('name')->filter()->values() : collect();
  $featureNames  = $property->features ? $property->features->pluck('name')->filter()->values() : collect();

  // 受入性別（belongsTo）
  $genderName = ($property->gender && $property->gender->name) ? $property->gender->name : '—';

  // 地域（都道府県 + 市区町村）
  $areaName = ($property->area && $property->area->name) ? $property->area->name : '—';
  $cityText = ($property->cities && $property->cities->count() > 0)
              ? $property->cities->pluck('name')->filter()->implode(' / ')
              : '';
  $regionText = trim($areaName . ($cityText ? " / {$cityText}" : ""));

  // 最寄り駅（propertiesのDB値）
  $station = $property->nearest_station ? $property->nearest_station : '—';
  $walk = is_null($property->walk_minutes) ? null : (int)$property->walk_minutes;

  // 金額
  $rent  = (int)($property->rent ?? 0);
  $total = (int)($property->total ?? 0);

  // 空室
  $vacantText = ((int)$property->availability === 1) ? 'あり' : 'なし';
@endphp

<div class="container">

  {{-- ヘッダー（設計書の上段） --}}
  <div class="border rounded-4 p-4 mb-4" style="background-color: LightYellow;">
    <div class="d-flex justify-content-between align-items-start">
      <div>
        <div class="fw-bold fs-4">{{ $property->title }}</div>
        <div class="mt-1 text-secondary">
          支払合計金額：<span class="fw-bold">{{ number_format($total) }}円</span>
        </div>

        <div class="small text-secondary">
          家賃 {{ number_format((int)$property->rent) }}円 /
          水道光熱費 {{ number_format((int)$property->utilities) }}円 /
          食材材料費 {{ number_format((int)$property->foodcosts) }}円 /
          日用品費 {{ number_format((int)$property->supplies) }}円 /
          その他費用 {{ number_format((int)$property->otherexpenses) }}円
        </div>
      </div>

      <div class="text-end">
        <div class="mb-2">
          @auth
            <form method="POST" action="{{ route('favorites.store', $property->id) }}">
              @csrf
              <button class="btn btn-outline-secondary btn-sm">お気に入り登録☆</button>
            </form>
          @else
            <a class="btn btn-outline-secondary btn-sm" href="{{ route('login') }}">お気に入り登録☆</a>
          @endauth
        </div>
        <div class="small text-secondary">掲載日：{{ $postedAt }}</div>
      </div>
    </div>
  </div>

  {{-- 画像エリア（左：大画像 / 右：サムネ9枠） --}}
  <div class="row g-4 mb-4">
    <div class="col-lg-7">
      <div class="border rounded-4 p-3 bg-white">
        <div class="position-relative">
          <div class="ratio ratio-4x3 border rounded-3 overflow-hidden bg-light">
            <img id="mainImage" src="{{ $mainImg }}" alt="物件画像" class="w-100 h-100" style="object-fit: cover;">
          </div>

          <button type="button"
                  class="btn btn-light position-absolute top-50 start-0 translate-middle-y shadow-sm"
                  style="border-radius: 999px;"
                  id="prevBtn">‹</button>

          <button type="button"
                  class="btn btn-light position-absolute top-50 end-0 translate-middle-y shadow-sm"
                  style="border-radius: 999px;"
                  id="nextBtn">›</button>
        </div>
      </div>
    </div>

    <div class="col-lg-5">
      <div class="border rounded-4 p-3 bg-white">
        <div class="row g-2" id="thumbGrid">
          @php
            $thumbs = $images->take(9)->values();
          @endphp

          @for($i=0; $i<9; $i++)
            @php
              $thumb = $thumbs->get($i);
              $path = $thumb ? $thumb->image_path : null;
            @endphp

            <div class="col-4">
              <div class="ratio ratio-1x1 border rounded-3 overflow-hidden bg-light d-flex align-items-center justify-content-center"
                   style="cursor: {{ $path ? 'pointer' : 'default' }};"
                   data-img="{{ $path ? $path : '' }}">
                @if($path)
                  <img src="{{ $path }}" alt="サムネ" class="w-100 h-100" style="object-fit: cover;">
                @else
                  <div class="small text-secondary">物件画像</div>
                @endif
              </div>
            </div>
          @endfor
        </div>
      </div>
    </div>
  </div>

  {{-- 物件説明文 --}}
  <div class="border rounded-4 p-4 mb-4 bg-white">
    <div class="fw-bold mb-2 text-center">物件説明文</div>
    <div class="text-secondary">
      {{ $property->description ? $property->description : '—' }}
    </div>
  </div>

  {{-- ボタン群（設計書のボタン群） --}}
  <div class="border rounded-4 p-4 mb-4 bg-white">
    <div class="d-flex flex-wrap gap-2 justify-content-center">
      <span class="btn btn-outline-primary btn-sm">
        事業種：
        {{ $businessNames->isNotEmpty() ? $businessNames->implode(' / ') : '—' }}
      </span>

      <span class="btn btn-outline-primary btn-sm">
        障害支援区分：
        {{ ($property->levelDisability && $property->levelDisability->name) ? $property->levelDisability->name : '—' }}
      </span>

      <span class="btn btn-outline-primary btn-sm">
        受入性別：
        {{ $genderName }}
      </span>

      <span class="btn btn-outline-primary btn-sm">
        建物タイプ：
        {{ $buildingNames->isNotEmpty() ? $buildingNames->implode(' / ') : '—' }}
      </span>

      <span class="btn btn-outline-primary btn-sm">
        その他特徴：
        {{ $featureNames->isNotEmpty() ? $featureNames->implode(' / ') : '—' }}
      </span>
    </div>
  </div>

  {{-- 下段の表（設計書の表） --}}
  <div class="border rounded-4 overflow-hidden mb-4 bg-white">
    <div class="row g-0">
      <div class="col-6 border-end border-bottom p-3">
        <div class="text-secondary small">家賃</div>
        <div class="fw-bold">{{ number_format((int)$property->rent) }}円</div>
      </div>
      <div class="col-3 border-end border-bottom p-3">
        <div class="text-secondary small">定員</div>
        <div class="fw-bold">{{ (int)$property->capacity }}名</div>
      </div>
      <div class="col-3 border-bottom p-3">
        <div class="text-secondary small">空室状況</div>
        <div class="fw-bold text-dark">{{ $vacantText }}</div>
      </div>

      <div class="col-6 border-end border-bottom p-3">
        <div class="text-secondary small">水道光熱費</div>
        <div class="fw-bold">{{ number_format((int)$property->utilities) }}円</div>
      </div>
      <div class="col-6 border-bottom p-3">
        <div class="text-secondary small">住所</div>
        <div class="fw-bold">{{ $property->address }}</div>
      </div>

      <div class="col-6 border-end border-bottom p-3">
        <div class="text-secondary small">食材材料費</div>
        <div class="fw-bold">{{ number_format((int)$property->foodcosts) }}円</div>
      </div>
      <div class="col-6 border-bottom p-3">
        <div class="text-secondary small">事業者名</div>
        <div class="fw-bold">{{ $property->businessname }}</div>
      </div>

      <div class="col-6 border-end border-bottom p-3">
        <div class="text-secondary small">日用品費</div>
        <div class="fw-bold">{{ number_format((int)$property->supplies) }}円</div>
      </div>
      <div class="col-6 border-bottom p-3">
        <div class="text-secondary small">連絡先</div>
        <div class="fw-bold">{{ $property->contactaddress }}</div>
      </div>

      <div class="col-6 border-end p-3">
        <div class="text-secondary small">その他費用</div>
        <div class="fw-bold">{{ number_format((int)$property->otherexpenses) }}円</div>
      </div>
      <div class="col-6 p-3">
        <div class="text-secondary small">最寄り駅</div>
        <div class="fw-bold text-dark">
          {{ $station }}
          @if(!is_null($walk))
            ／ 徒歩{{ $walk }}分
          @endif
        </div>
      </div>
    </div>

    <div class="border-top p-3">
      <div class="text-secondary small">合計</div>
      <div class="fw-bold">{{ number_format((int)$property->total) }}円</div>
    </div>
  </div>

  {{-- 問い合わせボタン --}}
  <div class="text-center mb-5">
    <a class="btn px-5 text-white"
       style="background-color:#ff9800;"
       href="{{ route('inquiries.create', $property->id) }}">
      お問い合わせはこちら
    </a>
  </div>

</div>

<script>
  (function () {
    const main = document.getElementById('mainImage');

    const thumbs = Array.from(document.querySelectorAll('#thumbGrid [data-img]'))
      .map(el => el.getAttribute('data-img'))
      .filter(Boolean);

    let idx = 0;

    function setImage(i) {
      if (!thumbs.length) return;
      idx = (i + thumbs.length) % thumbs.length;
      main.src = thumbs[idx];
    }

    if (thumbs.length) {
      main.src = thumbs[0];
    }

    document.querySelectorAll('#thumbGrid [data-img]').forEach((el) => {
      const src = el.getAttribute('data-img');
      if (!src) return;
      el.addEventListener('click', () => {
        const i = thumbs.indexOf(src);
        if (i >= 0) setImage(i);
      });
    });

    const prev = document.getElementById('prevBtn');
    const next = document.getElementById('nextBtn');

    if (prev) prev.addEventListener('click', () => setImage(idx - 1));
    if (next) next.addEventListener('click', () => setImage(idx + 1));
  })();
</script>
@endsection
