@extends('layouts.app')
@section('title', 'ユーザー問い合わせ管理')

@section('content')
<h1 class="text-2xl font-bold">ユーザー問い合わせ管理</h1>

<div class="bg-white border rounded-2xl shadow-sm p-6 mt-6 overflow-x-auto">
  <table class="w-full border text-sm">
    <tr class="bg-slate-50">
      <th class="border px-3 py-2 text-left">ID</th>
      <th class="border px-3 py-2 text-left">ユーザー</th>
      <th class="border px-3 py-2 text-left">物件ID</th>
      <th class="border px-3 py-2 text-left">内容</th>
      <th class="border px-3 py-2 text-left">日時</th>
      <th class="border px-3 py-2"></th>
    </tr>
    <tr>
      <td class="border px-3 py-2">501</td><td class="border px-3 py-2">山田 太郎</td><td class="border px-3 py-2">1001</td>
      <td class="border px-3 py-2">見学希望</td><td class="border px-3 py-2">2025-12-15</td>
      <td class="border px-3 py-2"><a class="px-3 py-1 rounded-full border hover:bg-slate-50" href="#">物件</a></td>
    </tr>
    <tr>
      <td class="border px-3 py-2">502</td><td class="border px-3 py-2">佐藤 花子</td><td class="border px-3 py-2">1002</td>
      <td class="border px-3 py-2">料金詳細</td><td class="border px-3 py-2">2025-12-16</td>
      <td class="border px-3 py-2"><a class="px-3 py-1 rounded-full border hover:bg-slate-50" href="#">物件</a></td>
    </tr>
  </table>
</div>
@endsection
