@extends('layouts.app')
@section('title','物件検索')

@section('content')
<h1 class="fw-bold mb-3">物件検索</h1>

<div class="p-4 bg-white border rounded-4">
  <form method="GET" action="{{ route('property.result') }}" class="row g-3">
    {{-- 都道府県 --}}
    <div class="col-md-6">
      <label class="form-label fw-semibold">都道府県</label>
      <select name="pref" class="form-select">
        <option value="">都道府県を選択</option>
        <option value="東京都" @selected(request('pref')==='東京都')>東京都</option>
        <option value="神奈川県" @selected(request('pref')==='神奈川県')>神奈川県</option>
        <option value="大阪府" @selected(request('pref')==='大阪府')>大阪府</option>
      </select>
    </div>

    {{-- 市区町村 --}}
    <div class="col-md-6">
      <label class="form-label fw-semibold">市区町村</label>
      <select name="city" class="form-select">
        <option value="">市区町村を選択</option>
        <option value="〇〇区" @selected(request('city')==='〇〇区')>〇〇区</option>
        <option value="〇〇市" @selected(request('city')==='〇〇市')>〇〇市</option>
      </select>
      <div class="form-text">※本来は都道府県に応じて変動</div>
    </div>

    {{-- 事業種類 --}}
    <div class="col-12">
      <label class="form-label fw-semibold">事業種類</label>
      @php $business = (array)request('business', []); @endphp
      <div class="d-flex flex-wrap gap-3">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="business[]" value="home" id="bHome"
                 @checked(in_array('home',$business))>
          <label class="form-check-label" for="bHome">グループホーム</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="business[]" value="welfare" id="bWelfare"
                 @checked(in_array('welfare',$business))>
          <label class="form-check-label" for="bWelfare">福祉サービス</label>
        </div>
      </div>
    </div>

    {{-- 障害者 区分 --}}
    <div class="col-12">
      <label class="form-label fw-semibold">障害者 区分</label>
      @php $level = (array)request('level', []); @endphp
      <div class="d-flex flex-wrap gap-3">
        @for($i=1;$i<=3;$i++)
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="level[]" value="{{ $i }}" id="lv{{ $i }}"
                   @checked(in_array((string)$i, array_map('strval',$level)))>
            <label class="form-check-label" for="lv{{ $i }}">区分{{ $i }}</label>
          </div>
        @endfor
      </div>
    </div>

    {{-- 家賃 --}}
    <div class="col-md-6">
      <label class="form-label fw-semibold">家賃</label>
      <select name="rent" class="form-select">
        <option value="">金額を選択</option>
        <option value="50000" @selected(request('rent')==='50000')>〜50,000円</option>
        <option value="80000" @selected(request('rent')==='80000')>〜80,000円</option>
        <option value="100000" @selected(request('rent')==='100000')>〜100,000円</option>
      </select>
    </div>

    {{-- 受入性別 --}}
    <div class="col-md-6">
      <label class="form-label fw-semibold">受入性別</label>
      <select name="gender" class="form-select">
        <option value="">性別を選択</option>
        <option value="male" @selected(request('gender')==='male')>男性</option>
        <option value="female" @selected(request('gender')==='female')>女性</option>
        <option value="any" @selected(request('gender')==='any')>男女可</option>
      </select>
    </div>

    {{-- 建物タイプ --}}
    <div class="col-12">
      <label class="form-label fw-semibold">建物タイプ</label>
      @php $building = (array)request('building', []); @endphp
      <div class="d-flex flex-wrap gap-3">
        @foreach([['house','戸建て'],['mansion','マンション'],['apartment','アパート']] as [$val,$label])
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="building[]" value="{{ $val }}" id="bd{{ $val }}"
                   @checked(in_array($val,$building))>
            <label class="form-check-label" for="bd{{ $val }}">{{ $label }}</label>
          </div>
        @endforeach
      </div>
    </div>

    {{-- その他情報 --}}
    <div class="col-12">
      <label class="form-label fw-semibold">その他情報</label>
      @php $feature = (array)request('feature', []); @endphp
      <div class="d-flex flex-wrap gap-3">
        @foreach([['barrierfree','バリアフリー'],['meals','食事提供'],['support','生活サポート']] as [$val,$label])
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="feature[]" value="{{ $val }}" id="ft{{ $val }}"
                   @checked(in_array($val,$feature))>
            <label class="form-check-label" for="ft{{ $val }}">{{ $label }}</label>
          </div>
        @endforeach
      </div>
    </div>

    {{-- フリーワード --}}
    <div class="col-12">
      <label class="form-label fw-semibold">フリーワード</label>
      <input name="q" class="form-control" value="{{ request('q') }}" placeholder="例）駅近／バリアフリー／〇〇区 など">
    </div>

    <div class="col-12 d-grid gap-2">
      <button class="btn btn-primary py-2">検索</button>
      <a class="btn btn-outline-secondary py-2" href="{{ route('properties.index') }}">物件一覧へ</a>
    </div>
  </form>
</div>
@endsection
