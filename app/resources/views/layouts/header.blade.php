<header class="bg-white border-b">
  <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between gap-4">
    <a href="{{ url('/') }}" class="flex items-center gap-3">
      <div class="w-10 h-10 rounded-xl border flex items-center justify-center font-bold">H</div>
      <div>
        <div class="font-bold leading-tight">Helping Heart</div>
        <div class="text-xs text-slate-500">福祉住まい検索 / 相談</div>
      </div>
    </a>

    <nav class="flex flex-wrap items-center gap-2">
      {{-- 認証状態で出し分け（必要に応じて調整） --}}
      @auth
        <a class="px-4 py-2 rounded-full border hover:bg-slate-50" href="{{ route('mypage.index') }}">マイページ</a>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button class="px-4 py-2 rounded-full border hover:bg-slate-50" type="submit">ログアウト</button>
        </form>
      @else
        <a class="px-4 py-2 rounded-full border hover:bg-slate-50" href="{{ route('signup') }}">会員登録</a>
        <a class="px-4 py-2 rounded-full bg-blue-600 text-white hover:bg-blue-700" href="{{ route('login') }}">ログイン</a>
      @endauth

      {{-- 管理者導線（必要ならGate等で制御） --}}
      <a class="px-4 py-2 rounded-full border hover:bg-slate-50" href="{{ route('admin.dashboard') }}">管理</a>
    </nav>
  </div>
</header>
