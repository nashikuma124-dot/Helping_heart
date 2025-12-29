<header class="hh-header">
  <div class="container py-3 d-flex align-items-center justify-content-between gap-3">

    <a href="{{ route('top') }}" class="d-flex align-items-center gap-3 text-decoration-none">
      <img src="{{ asset('images/logo.png') }}" alt="Helping heart" style="height:70px; width:auto;">
      <div class="d-none d-md-block">
        <div class="fs-3 fw-bold text-white lh-1">Helping heart</div>
        <div class="text-white-50">福祉グループホーム</div>
      </div>
    </a>

<nav class="d-flex align-items-center gap-2">
  @auth
    <a class="btn btn-light text-orange fw-semibold" href="{{ route('mypage.index') }}">マイページ</a>
    <a class="btn btn-outline-light" href="{{ route('consultation.index') }}">相談</a>

    <form method="POST" action="{{ route('logout') }}" class="d-inline">
      @csrf
      <button class="btn btn-outline-light">ログアウト</button>
    </form>
  @else
    <a class="btn btn-outline-light" href="{{ route('signup') }}">会員登録</a>
    <a class="btn btn-light text-orange fw-semibold" href="{{ route('login') }}">ログイン</a>
  @endauth

  {{-- 管理（必要なければ消してOK） --}}
  <a class="btn btn-outline-light" href="{{ route('admin.dashboard') }}">管理</a>
</nav>


  </div>
</header>
