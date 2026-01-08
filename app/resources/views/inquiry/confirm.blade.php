@extends('layouts.app')
@section('title','お問い合わせ内容確認')

@section('content')
@php
  // Controller から $property が渡ってくる想定
  // 送信値（confirmでvalidate済み）
  $inquiryType = old('inquiry_type', request('inquiry_type'));
  $message     = old('message', request('message'));
  $name        = old('name', request('name'));
  $email       = old('email', request('email'));
  $tel         = old('tel', request('tel'));

  $typeLabel = [
    'plan' => 'プランや料金の詳細を知りたい',
    'tour' => '見学を希望したい',
    'other' => 'その他のお問い合わせ',
  ][$inquiryType] ?? '—';

  // 物件側
  $propTitle   = $property->title ?? '—';
  $propAddress = $property->address ?? '—';

  // 「家賃・支払合計金額」：あなたの画面仕様に合わせる
  // 例）家賃＝rent、支払合計＝total
  $propRent  = isset($property->rent) ? number_format((int)$property->rent).'円' : '—';
  $propTotal = isset($property->total) ? number_format((int)$property->total).'円' : '—';

  $propBusiness = $property->businessname ?? '—';

  // 入力に戻る時に値を保持して戻す用（GET）
  $backQuery = http_build_query([
    'property_id'  => $property->id ?? null,
    'inquiry_type' => $inquiryType,
    'message'      => $message,
    'name'         => $name,
    'email'        => $email,
    'tel'          => $tel,
  ]);
@endphp

<div class="container" style="max-width: 820px;">
  <div class="border rounded-4 p-4 bg-white">

    <div class="text-center fw-bold mb-4" style="font-size:18px;">
      ＜お問い合わせ内容確認＞
    </div>

    {{-- 入力内容 --}}
    <div class="fw-bold mb-2">入力内容</div>
    <div class="table-responsive mb-4">
      <table class="table table-bordered align-middle mb-0">
        <tbody>
          <tr>
            <th style="width: 220px;" class="bg-light">お問い合わせ内容</th>
            <td>{{ $typeLabel }}</td>
          </tr>
          <tr>
            <th class="bg-light">お名前</th>
            <td>{{ $name ?: '—' }}</td>
          </tr>
          <tr>
            <th class="bg-light">メールアドレス</th>
            <td>{{ $email ?: '—' }}</td>
          </tr>
          <tr>
            <th class="bg-light">電話番号</th>
            <td>{{ $tel ?: '—' }}</td>
          </tr>

          {{-- 「その他」のときだけ詳細内容を表示（任意） --}}
          @if($inquiryType === 'other')
            <tr>
              <th class="bg-light">詳細内容</th>
              <td style="white-space: pre-wrap;">{{ $message ?: '—' }}</td>
            </tr>
          @endif
        </tbody>
      </table>
    </div>

    {{-- 問い合わせ物件 --}}
<div class="fw-bold mb-2">問い合わせ物件</div>
<div class="table-responsive mb-4">
  <table class="table table-bordered align-middle mb-0">
    <tbody>
      <tr>
        <th style="width: 220px;" class="bg-light">物件名</th>
        <td>{{ $property->title ?? '—' }}</td>
      </tr>
      <tr>
        <th class="bg-light">住所</th>
        <td>{{ $property->address ?? '—' }}</td>
      </tr>
      <tr>
        <th class="bg-light">家賃・支払合計金額</th>
        <td>
          家賃：{{ isset($property->rent) ? number_format((int)$property->rent).'円' : '—' }}
          ／
          支払合計：{{ isset($property->total) ? number_format((int)$property->total).'円' : '—' }}
        </td>
      </tr>
      <tr>
        <th class="bg-light">事業所</th>
        <td>{{ $property->businessname ?? '—' }}</td>
      </tr>
    </tbody>
  </table>
</div>


    {{-- ボタン --}}
    <div class="d-flex justify-content-between gap-3">
      {{-- ① 入力に戻る（値を保持して戻す） --}}
      <a class="btn btn-outline-secondary px-4"
        href="{{ route('inquiries.create', $property->id) }}">
        入力に戻る
      </a>


      {{-- ② 送信 --}}
      <form method="POST" action="{{ route('inquiries.store') }}">
        @csrf
        <input type="hidden" name="property_id" value="{{ $property->id ?? '' }}">
        <input type="hidden" name="inquiry_type" value="{{ $inquiryType }}">
        <input type="hidden" name="message" value="{{ $message }}">
        <input type="hidden" name="name" value="{{ $name }}">
        <input type="hidden" name="email" value="{{ $email }}">
        <input type="hidden" name="tel" value="{{ $tel }}">

        <button class="btn btn-outline-dark px-5">
          送信
        </button>
      </form>
    </div>

  </div>
</div>
@endsection
