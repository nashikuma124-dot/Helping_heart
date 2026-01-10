@extends('layouts.app')
@section('title','ログイン')

@section('content')
<h1 class="fw-bold mb-3 text-center">ログイン</h1>

<div class="p-4 bg-white border rounded-4" style="max-width:720px; margin:auto;">

  {{-- メアドログイン --}}
  <form method="POST" action="{{ route('login') }}" class="mx-auto" style="max-width:520px;">
    @csrf

    <div class="table-responsive">
      <table class="table table-bordered align-middle mb-3">
        <tbody>
          <tr>
            <th class="bg-light" style="width:180px;">メールアドレス</th>
            <td>
              <input name="email" type="email" class="form-control"
                     value="{{ old('email') }}" placeholder="メールアドレス入力" required>
              @error('email')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </td>
          </tr>
          <tr>
            <th class="bg-light">パスワード</th>
            <td>
              <input name="password" type="password" class="form-control"
                     placeholder="パスワード入力" required>
              @error('password')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="text-end mb-3">
      <a href="{{ route('password.request') }}" class="small text-decoration-underline">
        ※パスワードを忘れた方はこちら
      </a>
    </div>

    <div class="d-grid gap-3">
      <button type="submit" class="btn btn-primary py-2">ログイン</button>

      {{-- ✅ LINEログインボタン（GETなのでCSRF不要） --}}
      <a href="{{ route('line.login') }}" class="btn btn-outline-secondary py-2">
        LINEでログイン
      </a>
    </div>
  </form>

</div>
@endsection
