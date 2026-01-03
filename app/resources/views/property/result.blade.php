@extends('layouts.app')
@section('title','検索結果一覧')

@section('content')
<h1 class="fw-bold mb-3">検索結果一覧</h1>

<div class="row g-3">
  {{-- 条件表示 --}}
  <div class="col-lg-4">
    <div class="p-4 bg-white border rounded-4">
      <div class="fw-bold mb-2">検索条件</div>

      <div class="small text-secondary">
        <div>都道府県ID：{{ request('area_id') ?: '—' }}</div>
        <div>市区町村：{{ implode(' / ', (array)request('city_ids', [])) ?: '—' }}</div>
        <div>キーワード：{{ request('q') ?: '—' }}</div>

        <div class="mt-2">
          事業：{{ implode(' / ', (array)request('business', [])) ?: '—' }}
        </div>
        <div>
          区分：{{ request('disability_level') ?: '—' }}
        </div>
        <div>
          家賃：{{ request('rent_min') ?: '—' }} 〜 {{ request('rent_max') ?: '—' }}
        </div>
        <div>
          性別：{{ implode(' / ', (array)request('gender', [])) ?: '—' }}
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
        <div class="d-flex flex-column gap-3 mt-3">
          @foreach($properties as $p)
            <div class="border rounded-4 p-3">
              <div class="d-flex justify-content-between align-items-start gap-2">
                <div>
                  <div class="fw-bold">{{ $p->title }}</div>
                  <div class="text-secondary small">
                    住所：{{ $p->address }}
                    / 空室：{{ (int)$p->availability === 1 ? 'あり' : 'なし' }}
                    / 定員：{{ $p->capacity }}名
                    / 家賃：{{ number_format((int)$p->rent) }}円
                  </div>
                </div>
                <span class="badge text-bg-light">#{{ $p->id }}</span>
              </div>

              <div class="d-flex flex-wrap gap-2 mt-3">
                <a class="btn btn-primary" href="{{ route('properties.show', $p->id) }}">詳細</a>

                @auth
                  <form method="POST" action="{{ route('favorites.store', $p->id) }}">
                    @csrf
                    <button class="btn btn-outline-secondary" type="submit">♡ お気に入り</button>
                  </form>
                @else
                  <a class="btn btn-outline-secondary" href="{{ route('login') }}">♡ お気に入り（要ログイン）</a>
                @endauth

                <a class="btn btn-outline-secondary" href="{{ route('inquiries.create', $p->id) }}">問い合わせ</a>
              </div>
            </div>
          @endforeach
        </div>

        {{-- ✅ GET条件を保持してページ送り --}}
        <div class="mt-4">
          {{ $properties->appends(request()->query())->links() }}
        </div>
      @endif

    </div>
  </div>
</div>
@endsection
