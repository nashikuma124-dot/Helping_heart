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
      @foreach($businessTypes as $bt)
        <div class="form-check me-3">
            <input class="form-check-input" type="checkbox"
                name="business[]" value="{{ $bt->id }}" id="bt{{ $bt->id }}"
                @checked(in_array((string)$bt->id, array_map('strval',$business)))>
            <label class="form-check-label" for="bt{{ $bt->id }}">{{ $bt->name }}</label>
        </div>
      @endforeach
    </div>

    {{-- 障害者区分 --}}
    <div class="col-12">
      <label class="form-label fw-semibold">障害者区分</label>
      <select name="disability_level" class="form-select">
        <option value="">区分を選択</option>
        <option value="1" @selected(request('disability_level')=='1')>区分1</option>
        <option value="2" @selected(request('disability_level')=='2')>区分2</option>
        <option value="3" @selected(request('disability_level')=='3')>区分3</option>
      </select>
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
      @php $gender = (array)request('gender', []); @endphp
      @foreach($gender as $g)
        <div class="form-check me-3">
          <input class="form-check-input" type="checkbox"
            name="gender[]" value="{{ $g->id }}" id="g{{ $g->id }}"
            @checked(in_array((string)$g->id, array_map('strval',$gender)))>
          <label class="form-check-label" for="g{{ $g->id }}">{{ $g->name }}</label>
        </div>
      @endforeach
    </div>

    {{-- 建物タイプ --}}
    <div class="col-12">
      <label class="form-label fw-semibold">建物タイプ</label>
      @php $building = (array)request('building', []); @endphp
      @foreach($buildingTypes as $b)
        <div class="form-check me-3">
          <input class="form-check-input" type="checkbox"
            name="building[]" value="{{ $b->id }}" id="b{{ $b->id }}"
            @checked(in_array((string)$b->id, array_map('strval',$building)))>
          <label class="form-check-label" for="b{{ $b->id }}">{{ $b->name }}</label>
        </div>
      @endforeach
    </div>

    {{-- その他特徴 --}}
    <div class="col-12">
      <label class="form-label fw-semibold">その他特徴</label>
      @php $feature = (array)request('feature', []); @endphp
      @foreach($features as $f)
        <div class="form-check me-3">
            <input class="form-check-input" type="checkbox"
                name="feature[]" value="{{ $f->id }}" id="f{{ $f->id }}"
                @checked(in_array((string)$f->id, array_map('strval',$feature)))>
            <label class="form-check-label" for="f{{ $f->id }}">{{ $f->name }}</label>
        </div>
      @endforeach
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
