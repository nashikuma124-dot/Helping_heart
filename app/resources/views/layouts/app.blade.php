<!doctype html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Helping heart')</title>

  {{-- Bootstrap --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  {{-- 自作CSS（オレンジヘッダー等） --}}
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="bg-light">

  @include('layouts.header')

  <main class="container py-4">
    @yield('content')
  </main>

  {{-- Bootstrap JS（必要な場合） --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  @stack('scripts')
</body>
</html>
