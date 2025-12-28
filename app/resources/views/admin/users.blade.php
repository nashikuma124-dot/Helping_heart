@extends('layouts.app')
@section('title', '会員ユーザー管理')

@section('content')
<h1 class="text-2xl font-bold">会員ユーザー管理</h1>

<div class="bg-white border rounded-2xl shadow-sm p-6 mt-6 overflow-x-auto">
  <table class="w-full border text-sm">
    <tr class="bg-slate-50">
      <th class="border px-3 py-2 text-left">ID</th>
      <th class="border px-3 py-2 text-left">氏名</th>
      <th class="border px-3 py-2 text-left">メール</th>
      <th class="border px-3 py-2 text-left">区分</th>
      <th class="border px-3 py-2 text-left">削除</th>
      <th class="border px-3 py-2"></th>
    </tr>
    <tr>
      <td class="border px-3 py-2">1</td><td class="border px-3 py-2">山田 太郎</td><td class="border px-3 py-2">taro@example.com</td>
      <td class="border px-3 py-2">一般</td><td class="border px-3 py-2">FALSE</td>
      <td class="border px-3 py-2"><a class="px-3 py-1 rounded-full border hover:bg-slate-50" href="#">詳細</a></td>
    </tr>
    <tr>
      <td class="border px-3 py-2">2</td><td class="border px-3 py-2">管理者</td><td class="border px-3 py-2">admin@example.com</td>
      <td class="border px-3 py-2">管理</td><td class="border px-3 py-2">FALSE</td>
      <td class="border px-3 py-2"><a class="px-3 py-1 rounded-full border hover:bg-slate-50" href="#">詳細</a></td>
    </tr>
  </table>
</div>
@endsection
