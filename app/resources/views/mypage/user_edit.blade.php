@extends('layouts.app')
@section('title','会員情報編集')

@section('content')
<div class="container" style="max-width: 900px;">

  <div class="border rounded-4 p-4 mb-4 bg-white">
    <div class="text-center fw-bold mb-4" style="font-size: 1.25rem;">
      会員情報編集
    </div>

    {{-- エラーメッセージ --}}
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('mypage.update', auth()->id()) }}">
      @csrf
      @method('PUT')

      <div class="d-flex justify-content-center">
        <table class="table table-bordered text-center align-middle" style="width: 520px;">
          <tbody>
            <tr>
              <th class="bg-light" style="width: 35%;">メールアドレス</th>
              <td style="width: 65%;">
                <input
                  type="email"
                  name="email"
                  class="form-control"
                  value="{{ old('email', $user->email ?? '') }}"
                  placeholder="メールアドレス入力"
                >
              </td>
            </tr>

            <tr>
              <th class="bg-light">パスワード</th>
              <td>
                <input
                  type="password"
                  name="password"
                  class="form-control"
                  placeholder="パスワード入力（英数字6文字以上）"
                  autocomplete="new-password"
                >
              </td>
            </tr>

            <tr>
              <th class="bg-light">パスワード確認入力</th>
              <td>
                <input
                  type="password"
                  name="password_confirmation"
                  class="form-control"
                  placeholder="パスワード確認入力（英数字6文字以上）"
                  autocomplete="new-password"
                >
              </td>
            </tr>

            <tr>
              <th class="bg-light">お名前</th>
              <td>
                <input
                  type="text"
                  name="name"
                  class="form-control"
                  value="{{ old('name', $user->name ?? '') }}"
                  placeholder="名前入力"
                  required
                >
              </td>
            </tr>

            <tr>
              <th class="bg-light">生年月日</th>
              <td>
                {{-- DBカラムが dateofbirth の想定 --}}
                @php
                  $dobVal = old('dob', $user->dateofbirth ?? '');
                @endphp
                <input
                  type="date"
                  name="dob"
                  class="form-control"
                  value="{{ $dobVal }}"
                  placeholder="生年月日入力"
                >
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="d-flex justify-content-center gap-3 mt-4">
  {{-- ⑥ 編集内容確認画面へ（confirmへPOST） --}}
  <button type="submit"
          class="btn btn-outline-secondary px-4"
          formaction="{{ route('mypage.edit.confirm') }}"
          formmethod="POST">
    ⑥ 編集内容確認画面へ
  </button>

  {{-- ⑦ 会員登録削除 --}}
  <button type="submit"
          class="btn btn-outline-secondary px-4"
          form="deleteForm"
          onclick="return confirm('本当に退会しますか？');">
    ⑦ 会員登録削除
  </button>
</div>

    </form>

    {{-- 退会フォーム（別フォーム） --}}
    <form id="deleteForm" method="POST" action="{{ route('user.delete') }}">
      @csrf
    </form>

  </div>
</div>
@endsection
