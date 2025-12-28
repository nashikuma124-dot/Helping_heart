@extends('layouts.app')
@section('title', '物件データ管理')

@section('content')
<h1 class="text-2xl font-bold">物件データ管理</h1>

<div class="bg-white border rounded-2xl shadow-sm p-6 mt-6">
  <div class="flex flex-wrap gap-2">
    <a class="px-5 py-2 rounded-full bg-blue-600 text-white font-semibold hover:bg-blue-700" href="#">新規登録</a>
    <a class="px-5 py-2 rounded-full border font-semibold hover:bg-slate-50" href="{{ route('admin.dashboard') }}">管理者トップ</a>
  </div>

  <div class="overflow-x-auto mt-4">
    <table class="w-full border text-sm">
      <tr class="bg-slate-50">
        <th class="border px-3 py-2 text-left">ID</th>
        <th class="border px-3 py-2 text-left">物件名</th>
        <th class="border px-3 py-2 text-left">公開</th>
        <th class="border px-3 py-2 text-left">空室</th>
        <th class="border px-3 py-2 text-left">更新日</th>
        <th class="border px-3 py-2"></th>
      </tr>
      <tr>
        <td class="border px-3 py-2">1001</td><td class="border px-3 py-2">物件A</td><td class="border px-3 py-2">公開</td><td class="border px-3 py-2">あり</td><td class="border px-3 py-2">2025-12-01</td>
        <td class="border px-3 py-2"><a class="px-3 py-1 rounded-full border hover:bg-slate-50" href="#">詳細</a></td>
      </tr>
      <tr>
        <td class="border px-3 py-2">1002</td><td class="border px-3 py-2">物件B</td><td class="border px-3 py-2">非公開</td><td class="border px-3 py-2">なし</td><td class="border px-3 py-2">2025-11-20</td>
        <td class="border px-3 py-2"><a class="px-3 py-1 rounded-full border hover:bg-slate-50" href="#">詳細</a></td>
      </tr>
    </table>
  </div>
</div>
@endsection
