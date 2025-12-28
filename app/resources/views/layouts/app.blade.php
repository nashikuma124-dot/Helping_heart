<!doctype html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Helping Heart')</title>

  {{-- Tailwind CDN（簡易） --}}
  <script src="https://cdn.tailwindcss.com"></script>

  @stack('head')
</head>
<body class="bg-slate-50 text-slate-900">
  @include('layouts.header')

  <main class="max-w-6xl mx-auto px-4 py-8">
    @yield('content')
  </main>

  @include('layouts.footer')

  @stack('scripts')
</body>
</html>
