@extends('layouts.app')
@section('title', '物件詳細')

@section('content')
@php
  // =========================
  // 画像（DB + dummy で補完）
  // =========================
  $dbImages = $property->images->sortBy('sort_order')->pluck('image_path')->filter()->values()->all();

  $dummyImages = [];
  for ($i = 1; $i <= 12; $i++) {
    $dummyImages[] = "/images/dummy/property_{$i}.JPG"; // 実ファイルに合わせる
  }

  $allImages = array_values(array_unique(array_merge($dbImages, $dummyImages)));

  $visibleCount  = 8; // 最初に見せる枚数（6以上ならOK）
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

  // 障がい者区分（Propertyに relation がある前提）
  $disabilityName = (isset($property->levelDisability) && $property->levelDisability && $property->levelDisability->name)
      ? $property->levelDisability->name
      : '—';

  // 最寄り駅（properties）
  $station = $property->nearest_station ?: '—';
  $walk    = is_null($property->walk_minutes) ? null : (int)$property->walk_minutes;

  // 空室
  $vacantText = ((int)$property->availability === 1) ? 'あり' : 'なし';

  // 金額（表示で使う）
  $rent = (int)($property->rent ?? 0);

  // ★「家賃以外の合計」表示（DBのsubtotalを使う想定）
  // まだsubtotalが「合計」になってるなら、後で更新処理を入れて合わせる
  $othersTotal = (int)($property->subtotal ?? 0);
@endphp

<div class="container">

  {{-- ヘッダー --}}
  <div class="border rounded-4 p-4 mb-4" style="background-color: LightYellow;">
    <div class="d-flex justify-content-between align-items-start">
      <div>
        <div class="fw-bold fs-4">{{ $property->title }}</div>

        {{-- 指示：支払合計金額＝家賃 --}}
        <div class="mt-1 text-secondary">
          支払合計金額：<span class="fw-bold">{{ number_format($rent) }}円</span>
        </div>

        {{-- 指示：ここは家賃以外の合計 --}}
        <div class="small text-secondary">
          家賃以外の費用合計：<span class="fw-bold">{{ number_format($othersTotal) }}円</span>
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

  {{-- ✅ 画像ギャラリー（もっと見る / 会員のみ追加） --}}
  <div class="border rounded-4 p-3 mb-4 bg-white">
    <div class="row g-3">
      <div class="col-lg-6">
        <div class="ratio ratio-4x3 border rounded-3 overflow-hidden bg-light">
          <img id="mainImage" src="{{ $mainImage }}" alt="物件画像" class="w-100 h-100" style="object-fit:cover;">
        </div>

        <div class="d-flex flex-wrap gap-2 mt-3">
          @foreach($visibleImages as $idx => $src)
            <button type="button"
                    class="p-0 border rounded-2 overflow-hidden bg-light"
                    style="width:72px; height:54px;"
                    onclick="setMainImage('{{ $src }}')">
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

          {{-- 下段左 --}}
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

          {{-- 下段真ん中：もっと見る --}}
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

          {{-- 下段右：会員のみ追加 --}}
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

  {{-- 未表示画像モーダル --}}
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

  {{-- 物件説明文 --}}
  <div class="border rounded-4 p-4 mb-4 bg-white">
    <div class="fw-bold mb-2 text-center">物件説明文</div>
    <div class="text-secondary">
      {{ $property->description ?: '—' }}
    </div>
  </div>

  {{-- タグ（設計書のボタン群） --}}
  <div class="border rounded-4 p-4 mb-4 bg-white">
    <div class="d-flex flex-wrap gap-2 justify-content-center">
      <span class="btn btn-outline-primary btn-sm">
        事業種：
        {{ $businessNames->isNotEmpty() ? $businessNames->implode(' / ') : '—' }}
      </span>

      <span class="btn btn-outline-primary btn-sm">
        障害支援区分：
        {{ $disabilityName }}
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

  {{-- 下段の表 --}}
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

  {{-- 問い合わせ --}}
  <div class="text-center mb-5">
    <a class="btn px-5 text-white"
       style="background-color:#ff9800;"
       href="{{ route('inquiries.create', $property->id) }}">
      お問い合わせはこちら
    </a>
  </div>

</div>

<script>
  function setMainImage(src) {
    const el = document.getElementById('mainImage');
    if (el) el.src = src;
  }

  function closeMoreImagesModal() {
    const modalEl = document.getElementById('moreImagesModal');
    if (!modalEl) return;
    const modal = bootstrap.Modal.getInstance(modalEl);
    if (modal) modal.hide();
  }
</script>
@endsection
