@extends('layouts.app')
@section('title','会員情報編集')

@section('content')
<div class="container py-4">

  {{-- タイトル --}}
  <div class="text-center mb-4">
    <h1 class="fw-bold">会員情報編集</h1>
  </div>

  {{-- 枠 --}}
  <div class="bg-white border rounded-4 p-4 mx-auto" style="max-width: 760px;">

    <form method="POST" action="{{ route('mypage.edit.confirm') }}">
      @csrf

      {{-- 入力テーブル（画像の表レイアウトに寄せる） --}}
      <div class="table-responsive">
        <table class="table table-bordered align-middle mb-4" style="table-layout: fixed;">
          <tbody>
            {{-- メールアドレス --}}
            <tr>
              <th class="text-center bg-light" style="width: 30%;">メールアドレス</th>
              <td>
                <input
                  class="form-control"
                  name="email"
                  type="email"
                  value="{{ old('email', $user->email ?? '') }}"
                  required
                >
              </td>
            </tr>

            {{-- パスワード --}}
            <tr>
              <th class="text-center bg-light">パスワード</th>
              <td>
                <input
                  class="form-control"
                  name="password"
                  type="password"
                  autocomplete="new-password"
                  placeholder="英数字6文字以上（変更しない場合は空欄）"
                >
              </td>
            </tr>

            {{-- パスワード確認 --}}
            <tr>
              <th class="text-center bg-light">パスワード確認</th>
              <td>
                <input
                  class="form-control"
                  name="password_confirmation"
                  type="password"
                  autocomplete="new-password"
                  placeholder="確認のためもう一度入力"
                >
              </td>
            </tr>

            {{-- お名前 --}}
            <tr>
              <th class="text-center bg-light">お名前</th>
              <td>
                <input
                  class="form-control"
                  name="name"
                  value="{{ old('name', $user->name ?? '') }}"
                  required
                >
              </td>
            </tr>

            {{-- 生年月日 --}}
            <tr>
              <th class="text-center bg-light">生年月日</th>
              <td>
                <input
                  class="form-control"
                  type="date"
                  name="dob"
                  value="{{ old('dob', $user->dateofbirth ?? '') }}"
                >
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      {{-- ボタン（画像の⑥⑦） --}}
      <div class="d-flex justify-content-center gap-3">
        <button type="submit" class="btn btn-outline-dark px-4">
          ⑥ 編集内容確認画面へ
        </button>

        {{-- 「削除」は別画面に飛ばす想定（あなたのルートに合わせている） --}}
       <a href="{{ route('user.delete.confirm') }}" class="btn btn-outline-danger px-4">
        ⑦ 会員登録削除
       </a>


      </div>

    </form>

  </div>
</div>
@endsection
