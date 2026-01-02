@extends('layouts.app')
@section('title','物件検索')

@section('content')
<h1 class="fw-bold mb-3">物件検索</h1>

@php
  // 選択状態保持用（GET）
  $selectedAreaId      = (int) request('area_id', 0);
  $selectedCityIds     = array_map('intval', (array) request('city_ids', []));

  $selectedBusinessIds = array_map('intval', (array) request('business', []));
  $selectedGenderIds   = array_map('intval', (array) request('gender', []));
  $selectedBuildingIds = array_map('intval', (array) request('building', []));
  $selectedFeatureIds  = array_map('intval', (array) request('feature', []));

  $selectedDisability  = request('disability_level', '');
  $selectedRent        = request('rent', '');
  $qWord               = request('q', '');
@endphp

<div class="p-4 bg-white border rounded-4">
<form method="GET" action="{{ route('property.result') }}" class="row g-4">

{{-- ================= 都道府県 ================= --}}
<div class="col-lg-6">
  <label class="form-label fw-semibold">都道府県</label>
  <select name="area_id" id="areaSelect" class="form-select">
    <option value="">都道府県を選択</option>
    @foreach($areas as $area)
      <option value="{{ $area->id }}"
        {{ $selectedAreaId === (int)$area->id ? 'selected' : '' }}>
        {{ $area->name }}
      </option>
    @endforeach
  </select>
</div>

{{-- ================= 市区町村 ================= --}}
<div class="col-lg-6">
  <label class="form-label fw-semibold">市区町村（複数選択可）</label>
  <div id="cityBox" class="border rounded-3 p-3" style="min-height:120px;">
    <div class="text-muted small">都道府県を選択してください</div>
  </div>
  <input type="hidden" id="selectedCityIds" value='@json($selectedCityIds)'>
</div>

<hr>

{{-- ================= 事業種類 ================= --}}
<div class="col-12">
  <label class="form-label fw-semibold">事業種類（複数選択可）</label>
  <div class="d-flex flex-wrap gap-3">
    @foreach($businessTypes as $bt)
      <div class="form-check">
        <input class="form-check-input" type="checkbox"
          name="business[]" value="{{ $bt->id }}"
          id="business{{ $bt->id }}"
          {{ in_array((int)$bt->id, $selectedBusinessIds, true) ? 'checked' : '' }}>
        <label class="form-check-label" for="business{{ $bt->id }}">
          {{ $bt->name }}
        </label>
      </div>
    @endforeach
  </div>
</div>

{{-- ================= 障害者区分 ================= --}}
<div class="col-lg-6">
  <label class="form-label fw-semibold">障がい者区分</label>
  <select name="disability_level" class="form-select">
    <option value="">区分を選択</option>
    @foreach($levels as $lv)
      <option value="{{ $lv->id }}"
        {{ (string)$selectedDisability === (string)$lv->id ? 'selected' : '' }}>
        {{ $lv->name }}
      </option>
    @endforeach
  </select>
</div>


{{-- ================= 受入性別 ================= --}}
<div class="col-lg-6">
  <label class="form-label fw-semibold">受入性別（複数選択可）</label>
  <div class="d-flex flex-wrap gap-3">
    @foreach($genders as $g)
      <div class="form-check">
        <input class="form-check-input" type="checkbox"
          name="gender[]" value="{{ $g->id }}"
          id="gender{{ $g->id }}"
          {{ in_array((int)$g->id, $selectedGenderIds, true) ? 'checked' : '' }}>
        <label class="form-check-label" for="gender{{ $g->id }}">
          {{ $g->name }}
        </label>
      </div>
    @endforeach
  </div>
</div>

{{-- ================= 家賃 ================= --}}
@php
  $rentMin = request('rent_min', '');
  $rentMax = request('rent_max', '');
@endphp

<div class="col-lg-6">
  <label class="form-label fw-semibold">家賃（範囲）</label>

  <div class="row g-2 align-items-center">
    <div class="col">
      <select name="rent_min" class="form-select">
        <option value="">下限なし</option>
        @foreach($amounts as $a)
          <option value="{{ $a->amount }}">
            {{ number_format($a->amount) }}円
          </option>
        @endforeach
      </select>
    </div>

    <div class="col-auto">〜</div>

    <div class="col">
      <select name="rent_max" class="form-select">
        <option value="">上限なし</option>
        @foreach($amounts as $a)
          <option value="{{ $a->amount }}">
             {{ number_format($a->amount) }}円
          </option> 
        @endforeach
      </select>
    </div>
  </div>
</div>


{{-- ================= 建物タイプ ================= --}}
<div class="col-12">
  <label class="form-label fw-semibold">建物タイプ（複数選択可）</label>
  <div class="d-flex flex-wrap gap-3">
    @foreach($buildingTypes as $b)
      <div class="form-check">
        <input class="form-check-input" type="checkbox"
          name="building[]" value="{{ $b->id }}"
          id="building{{ $b->id }}"
          {{ in_array((int)$b->id, $selectedBuildingIds, true) ? 'checked' : '' }}>
        <label class="form-check-label" for="building{{ $b->id }}">
          {{ $b->name }}
        </label>
      </div>
    @endforeach
  </div>
</div>

{{-- ================= 特徴 ================= --}}
<div class="col-12">
  <label class="form-label fw-semibold">特徴（複数選択可）</label>
  <div class="d-flex flex-wrap gap-3">
    @foreach($features as $f)
      <div class="form-check">
        <input class="form-check-input" type="checkbox"
          name="feature[]" value="{{ $f->id }}"
          id="feature{{ $f->id }}"
          {{ in_array((int)$f->id, $selectedFeatureIds, true) ? 'checked' : '' }}>
        <label class="form-check-label" for="feature{{ $f->id }}">
          {{ $f->name }}
        </label>
      </div>
    @endforeach
  </div>
</div>

{{-- ================= フリーワード ================= --}}
<div class="col-12">
  <label class="form-label fw-semibold">フリーワード</label>
  <input name="q" class="form-control" value="{{ $qWord }}">
</div>

<div class="col-12 d-grid gap-2">
  <button class="btn btn-primary">検索</button>
</div>

</form>
</div>

{{-- ================= Ajax 市区町村 ================= --}}
<script>
const areaSelect = document.getElementById('areaSelect');
const cityBox = document.getElementById('cityBox');
const selectedCityIds = JSON.parse(document.getElementById('selectedCityIds').value || '[]');

async function loadCities(areaId) {
  cityBox.innerHTML = '';
  if (!areaId) {
    cityBox.innerHTML = '<div class="text-muted small">都道府県を選択してください</div>';
    return;
  }

  const res = await fetch(`{{ route('ajax.cities') }}?area_id=${areaId}`);
  const cities = await res.json();

  const wrap = document.createElement('div');
  wrap.className = 'd-flex flex-wrap gap-3';

  cities.forEach(c => {
    const div = document.createElement('div');
    div.className = 'form-check';

    const input = document.createElement('input');
    input.type = 'checkbox';
    input.name = 'city_ids[]';
    input.value = c.id;
    input.className = 'form-check-input';
    input.checked = selectedCityIds.includes(parseInt(c.id));

    const label = document.createElement('label');
    label.className = 'form-check-label';
    label.textContent = c.name;

    div.appendChild(input);
    div.appendChild(label);
    wrap.appendChild(div);
  });

  cityBox.appendChild(wrap);
}

areaSelect.addEventListener('change', e => {
  selectedCityIds.length = 0;
  loadCities(e.target.value);
});

document.addEventListener('DOMContentLoaded', () => {
  if (areaSelect.value) loadCities(areaSelect.value);
});
</script>
@endsection
