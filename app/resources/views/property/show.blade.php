@extends('layouts.app')
@section('title', '物件詳細')

@section('content')
@php
  // =========================
  // 画像準備（DB画像 + dummy補完）
  // =========================
  $dbImages = $property->images
    ->sortBy('sort_order')
    ->pluck('image_path')
    ->filter()
    ->values()
    ->all();

  $dummyImages = [];
  for ($i = 1; $i <= 12; $i++) {
    $dummyImages[] = "/images/dummy/property_{$i}.JPG";
  }

  $allImages = array_values(array_unique(array_merge($dbImages, $dummyImages)));

  $visibleCount  = 8;
  $visibleImages = array_slice($allImages, 0, $visibleCount);
  $hiddenImages  = array_slice($allImages, $visibleCount);

  $mainImage = $visibleImages[0] ?? ($allImages[0] ?? "/images/dummy/property_1.JPG");

  // =========================
  // 表示用データ
  // =========================
  $postedAt = $property->created_at ? $property->created_at->format('Y/m/d') : '—';

  $businessNames = $property->businessTypes ? $property->businessTypes->pluck('name')->filter()->values() : collect();
  $buildingNames = $property->buildingTypes ? $property->buildingTypes->pluck('name')->filter()->values() : collect();
  $featureNames  = $property->features ? $property->features->pluck('name')->filter()->values() : collect();

  $genderName = ($property->gender && $property->gender->name) ? $property->gender->name : '—';

  $areaName = ($property->area && $property->area->name) ? $property->area->name : '—';
  $cityText = ($property->cities && $property->cities->count() > 0)
              ? $property->cities->pluck('name')->filter()->implode(' / ')
              : '';
  $regionText = trim($areaName . ($cityText ? " / {$cityText}" : ""));

  $station = $property->nearest_station ? $property->nearest_station : '—';
  $walk    = is_null($property->walk_minutes) ? null : (int)$property->walk_minutes;

  $vacantText = ((int)$property->availability === 1) ? 'あり' : 'なし';

  $backUrl = url()->previous();
  if (is_string($backUrl) && preg_match('#/properties/\d+#', $backUrl)) {
    $backUrl = route('property.result');
  }
@endphp

<div class="container">

  {{-- ▼ ヘッダー --}}
  <div class="border rounded-4 p-4 mb-4" style="background-color: LightYellow;">
    <div class="d-flex justify-content-between align-items-start">
      <div>
        <div class="fw-bold fs-4">{{ $property->title }}</div>

        <div class="mt-1 text-secondary">
          家賃：<span class="fw-bold">{{ number_format((int)$property->rent) }}円</span>
        </div>

        <div class="small text-secondary">
          家賃以外の費用合計：
          <span class="fw-bold">{{ number_format((int)($property->subtotal ?? 0)) }}円</span>
        </div>

        <div class="small text-secondary mt-1">
          地域：{{ $regionText ?: '—' }}
        </div>
      </div>

      {{-- ✅ お気に入り（AJAXのみ / 遷移しない） --}}
@auth
  @php
    $isFav = auth()->user()
      ->favoriteProperties()
      ->where('properties.id', $property->id)
      ->exists();
  @endphp

  <div class="text-end">
    <div id="favMsg" class="small mb-2" style="display:none;"></div>

    <button
      type="button"
      id="favBtn"
      class="btn btn-sm {{ $isFav ? 'btn-dark' : 'btn-outline-secondary' }}"
      data-url="{{ route('favorites.store', $property->id) }}"
      {{ $isFav ? 'disabled' : '' }}
    >
      {{ $isFav ? '★ お気に入り' : '☆ お気に入り' }}
    </button>

    <div class="small text-secondary mt-2">掲載日：{{ $postedAt }}</div>
  </div>
@else
  <div class="text-end">
    <a class="btn btn-outline-secondary btn-sm" href="{{ route('login') }}">☆ お気に入り</a>
    <div class="small text-secondary mt-2">掲載日：{{ $postedAt }}</div>
  </div>
@endauth



    </div>
  </div>

  {{-- ▼ 物件画像ギャラリー --}}
  <div class="border rounded-4 p-3 mb-4" style="background-color: LightYellow;">
    <div class="row g-3">
      <div class="col-lg-6">
        <div class="ratio ratio-4x3 border rounded-3 overflow-hidden bg-light">
          <img id="mainImage"
               src="{{ $mainImage }}"
               alt="物件画像"
               class="w-100 h-100"
               style="object-fit:cover;">
        </div>

        <div class="d-flex flex-wrap gap-2 mt-3">
          @foreach($visibleImages as $idx => $src)
            <button type="button"
                    class="p-0 border rounded-2 overflow-hidden bg-light"
                    style="width:72px; height:54px;"
                    onclick="setMainImage('{{ $src }}')"
                    aria-label="画像{{ $idx+1 }}を表示">
              <img src="{{ $src }}" alt="サムネ" class="w-100 h-100" style="object-fit:cover;">
            </button>
          @endforeach
        </div>
      </div>

      <div class="col-lg-6">
        <div class="row g-2">
          @for($i=0; $i<6; $i++)
            @php $src = $visibleImages[$i] ?? null; @endphp
            <div class="col-4">
              <div class="border rounded-3 overflow-hidden bg-light" style="height:110px;">
                @if($src)
                  <button type="button" class="w-100 h-100 p-0 border-0 bg-transparent"
                          onclick="setMainImage('{{ $src }}')">
                    <img src="{{ $src }}" alt="物件画像" class="w-100 h-100" style="object-fit:cover;">
                  </button>
                @else
                  <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted small">物件画像</div>
                @endif
              </div>
            </div>
          @endfor

          @php $src7 = $visibleImages[6] ?? null; @endphp
          <div class="col-4">
            <div class="border rounded-3 overflow-hidden bg-light" style="height:110px;">
              @if($src7)
                <button type="button" class="w-100 h-100 p-0 border-0 bg-transparent"
                        onclick="setMainImage('{{ $src7 }}')">
                  <img src="{{ $src7 }}" alt="物件画像" class="w-100 h-100" style="object-fit:cover;">
                </button>
              @else
                <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted small">物件画像</div>
              @endif
            </div>
          </div>

          <div class="col-4">
            <button type="button"
                    class="border rounded-3 bg-white w-100 h-100 d-flex flex-column align-items-center justify-content-center"
                    style="height:110px;"
                    data-bs-toggle="modal"
                    data-bs-target="#moreImagesModal">
              <div class="fw-bold">もっと見る</div>
              <div class="text-muted small">未表示 {{ count($hiddenImages) }}枚</div>
            </button>
          </div>

          <div class="col-4">
            @auth
              <form method="POST"
                    action="{{ route('properties.images.store', $property->id) }}"
                    enctype="multipart/form-data"
                    class="border rounded-3 bg-white w-100 h-100 d-flex flex-column align-items-center justify-content-center"
                    style="height:110px;">
                @csrf
                <label class="btn btn-outline-secondary btn-sm mb-2">
                  + 写真追加
                  <input type="file" name="image" accept="image/*" class="d-none" onchange="this.form.submit()">
                </label>
                <div class="text-muted small">会員のみ</div>
              </form>
            @else
              <a href="{{ route('login') }}"
                 class="border rounded-3 bg-white w-100 h-100 d-flex flex-column align-items-center justify-content-center text-decoration-none"
                 style="height:110px; color:#333;">
                <div class="fw-bold">+ 写真追加</div>
                <div class="text-muted small">ログインが必要</div>
              </a>
            @endauth
          </div>

        </div>
      </div>
    </div>
  </div>

  {{-- ▼ 未表示画像モーダル --}}
  <div class="modal fade" id="moreImagesModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">他の物件画像</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
        </div>
        <div class="modal-body">
          @if(empty($hiddenImages))
            <div class="text-muted">未表示の画像はありません。</div>
          @else
            <div class="row g-2">
              @foreach($hiddenImages as $src)
                <div class="col-4 col-md-3">
                  <button type="button"
                          class="p-0 border rounded-3 overflow-hidden bg-light w-100"
                          style="height:110px;"
                          onclick="setMainImage('{{ $src }}'); closeMoreImagesModal();">
                    <img src="{{ $src }}" alt="物件画像" class="w-100 h-100" style="object-fit:cover;">
                  </button>
                </div>
              @endforeach
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>

  {{-- ▼ 物件説明文 --}}
  <div class="border rounded-4 p-4 mb-4" style="background-color: LightYellow;">
    <div class="fw-bold mb-2 text-center">物件説明文</div>
    <div class="text-secondary">
      {{ $property->description ? $property->description : '—' }}
    </div>
  </div>

  {{-- ▼ タグ表示 --}}
  <div class="border rounded-4 p-4 mb-4" style="background-color: LightYellow;">
    <div class="d-flex flex-wrap gap-2 justify-content-center">
      <div class="px-3 py-2 border rounded-3" style="background-color: PaleGreen;">
        <span class="fw-bold">事業種：</span>
        {{ $businessNames->isNotEmpty() ? $businessNames->implode(' / ') : '—' }}
      </div>

      <div class="px-3 py-2 border rounded-3" style="background-color: PaleGreen;">
        <span class="fw-bold">障害支援区分：</span>
        {{ ($property->levelDisability && $property->levelDisability->name) ? $property->levelDisability->name : '—' }}
      </div>

      <div class="px-3 py-2 border rounded-3" style="background-color: PaleGreen;">
        <span class="fw-bold">受入性別：</span>
        {{ $genderName }}
      </div>

      <div class="px-3 py-2 border rounded-3" style="background-color: PaleGreen;">
        <span class="fw-bold">建物タイプ：</span>
        {{ $buildingNames->isNotEmpty() ? $buildingNames->implode(' / ') : '—' }}
      </div>

      <div class="px-3 py-2 border rounded-3" style="background-color: PaleGreen;">
        <span class="fw-bold">その他特徴：</span>
        {{ $featureNames->isNotEmpty() ? $featureNames->implode(' / ') : '—' }}
      </div>
    </div>
  </div>

  {{-- ▼ 下段の表 --}}
  <div class="border rounded-4 overflow-hidden mb-4" style="background-color: LightYellow;">
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

  {{-- ▼ お問い合わせ + 一覧へ戻る --}}
  <div class="text-center mb-5">
    <a class="btn px-5 text-white" style="background-color:#ff9800;"
       href="{{ route('inquiries.create', $property->id) }}">
      お問い合わせはこちら
    </a>

    <div class="mt-3">
      <a class="btn btn-outline-secondary px-5" href="{{ $backUrl }}">
        一覧へ戻る
      </a>
    </div>
  </div>

</div>
{{-- ✅ このページ内に直書き（@pushは使わない） --}}
<script>
(function () {
  document.addEventListener('DOMContentLoaded', function () {
    const btn = document.getElementById('favBtn');
    const msg = document.getElementById('favMsg');

    if (!btn || !msg) return;

    btn.addEventListener('click', async function (e) {
      e.preventDefault();
      e.stopPropagation();

      // 初期化
      msg.style.display = 'none';
      msg.className = 'small mb-2';

      btn.disabled = true;

      try {
        const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        const url = btn.dataset.url;

        const res = await fetch(url, {
          method: 'POST',
          credentials: 'same-origin', // ✅ セッションCookieを必ず送る
          headers: {
            'X-CSRF-TOKEN': csrf,
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
          },
        });

        const ct = res.headers.get('content-type') || '';

        // JSONが返ってない（=ログイン画面HTML/エラーHTML等）を検知
        if (!ct.includes('application/json')) {
          msg.className = 'small text-danger mb-2';
          msg.textContent = 'お気に入り登録に失敗しました（JSON応答ではありません）';
          msg.style.display = 'block';
          btn.disabled = false;
          return;
        }

        const data = await res.json();

        if (!res.ok || !data.ok) {
          msg.className = 'small text-danger mb-2';
          msg.textContent = data.message || 'お気に入り登録に失敗しました';
          msg.style.display = 'block';
          btn.disabled = false;
          return;
        }

        // ✅ 成功：★黒 + メッセージ
        btn.classList.remove('btn-outline-secondary');
        btn.classList.add('btn-dark');
        btn.textContent = '★ お気に入り';
        btn.disabled = true;

        msg.className = 'small text-success mb-2';
        msg.textContent = data.message || 'お気に入りに登録されました';
        msg.style.display = 'block';

      } catch (err) {
        msg.className = 'small text-danger mb-2';
        msg.textContent = 'お気に入り登録に失敗しました';
        msg.style.display = 'block';
        btn.disabled = false;
      }
    });
  });
})();
</script>
@endpush
