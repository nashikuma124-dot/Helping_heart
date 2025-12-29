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
        <div>都道府県：{{ request('pref') ?: '—' }}</div>
        <div>市区町村：{{ request('city') ?: '—' }}</div>
        <div>キーワード：{{ request('q') ?: '—' }}</div>
        <div class="mt-2">
          事業：{{ implode(' / ', (array)request('business', [])) ?: '—' }}
        </div>
        <div>
          区分：{{ implode(' / ', (array)request('level', [])) ?: '—' }}
        </div>
        <div>
          家賃：{{ request('rent') ?: '—' }}
        </div>
        <div>
          性別：{{ request('gender') ?: '—' }}
        </div>
      </div>

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
        <div class="text-secondary small">※仕様：1ページ10件／新しい順（デモ）</div>
      </div>

      @php
        // 本来はControllerで検索結果を渡す。
        // ここは画面テンプレ用のダミー。
        $items = [
          ['id'=>1001,'title'=>'物件情報 1','address'=>'東京都〇〇区','vacant'=>'あり','capacity'=>5],
          ['id'=>1002,'title'=>'物件情報 2','address'=>'東京都〇〇区','vacant'=>'あり','capacity'=>6],
          ['id'=>1003,'title'=>'物件情報 3','address'=>'大阪府〇〇市','vacant'=>'なし','capacity'=>6],
        ];
      @endphp

      <div class="d-flex flex-column gap-3 mt-3">
        @foreach($items as $p)
          <div class="border rounded-4 p-3">
            <div class="d-flex justify-content-between align-items-start gap-2">
              <div>
                <div class="fw-bold">{{ $p['title'] }}</div>
                <div class="text-secondary small">
                  住所：{{ $p['address'] }} / 空室：{{ $p['vacant'] }} / 定員：{{ $p['capacity'] }}名
                </div>
              </div>
              <span class="badge text-bg-light">#{{ $p['id'] }}</span>
            </div>

            <div class="d-flex flex-wrap gap-2 mt-3">
              {{-- ResourceControllerの詳細へ（properties.show） --}}
              <a class="btn btn-primary" href="{{ route('properties.show', $p['id']) }}">詳細</a>

              @auth
                {{-- favorites.store（Resource） --}}
                <form method="POST" action="{{ route('favorites.store', $p['id']) }}">
                  @csrf
                  <button class="btn btn-outline-secondary" type="submit">♡ お気に入り</button>
                </form>
              @else
                <a class="btn btn-outline-secondary" href="{{ route('login') }}">♡ お気に入り（要ログイン）</a>
              @endauth

              {{-- 問い合わせへ --}}
              <a class="btn btn-outline-secondary" href="{{ route('inquiries.create', $p['id']) }}">問い合わせ</a>
            </div>
          </div>
        @endforeach
      </div>

    </div>
  </div>
</div>
@endsection
