@extends('layouts.app')
@section('title','チャット相談窓口')

@section('content')
<div class="mx-auto" style="max-width: 860px;">

  {{-- 見出しエリア（画像の中央寄せに寄せる） --}}
  <div class="text-center my-4">
    <h1 class="fw-bold mb-3" style="letter-spacing: .04em;">LINE相談案内</h1>

    <p class="mb-0 text-secondary fw-semibold">
      公式LINEに友達追加するだけで<br class="d-md-none">
      チャット相談ができます
    </p>
  </div>

  {{-- 本体枠（画像の四角枠っぽく） --}}
  <div class="bg-white border rounded-4 p-4 p-md-5">

    <div class="row g-4 text-center align-items-start">

      {{-- 左：グループホーム --}}
      <div class="col-md-6">
        <p class="mb-2 fw-semibold text-secondary">
          グループホームに<br>ついてのご相談は
        </p>
        <div class="fw-bold mb-2">こちら</div>

        {{-- 矢印（文字で表現） --}}
        <div class="mb-3" style="font-size: 22px; line-height: 1;">↓</div>

        {{-- 角丸枠ボタン（画像の枠っぽい） --}}
        <a href="https://line.me/R/ti/p/@324zkaqh"
           target="_blank"
           class="d-inline-flex justify-content-center align-items-center text-decoration-none text-dark fw-bold"
           style="
             width: 280px;
             min-height: 72px;
             border: 2px solid #333;
             border-radius: 14px;
             background: #fff;
           ">
          ①グループホーム<br>相談窓口LINE<br>友達追加
        </a>
      </div>

      {{-- 右：福祉サービス --}}
      <div class="col-md-6">
        <p class="mb-2 fw-semibold text-secondary">
          その他福祉サービスに<br>ついてのご相談は
        </p>
        <div class="fw-bold mb-2">こちら</div>

        <div class="mb-3" style="font-size: 22px; line-height: 1;">↓</div>

        <a href="https://line.me/R/ti/p/@943vieay"
           target="_blank"
           class="d-inline-flex justify-content-center align-items-center text-decoration-none text-dark fw-bold"
           style="
             width: 280px;
             min-height: 72px;
             border: 2px solid #333;
             border-radius: 14px;
             background: #fff;
           ">
          ②福祉サービス<br>相談窓口LINE<br>友達追加
        </a>
      </div>

    </div>

    {{-- 下の注記 --}}
    <div class="text-center mt-4 small text-secondary">
      ※LINEアプリが起動します
    </div>

  </div>
</div>
@endsection
