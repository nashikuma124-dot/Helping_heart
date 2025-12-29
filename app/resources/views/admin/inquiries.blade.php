@extends('layouts.app')
@section('title','ユーザー問い合わせ管理')

@section('content')
<h1 class="fw-bold mb-3">ユーザー問い合わせ管理</h1>

<div class="p-4 bg-white border rounded-4">
  <div class="table-responsive">
    <table class="table table-bordered align-middle">
      <thead class="table-light">
        <tr>
          <th>ID</th>
          <th>ユーザー</th>
          <th>物件ID</th>
          <th>内容</th>
          <th>日時</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @foreach([
          ['id'=>501,'user'=>'山田 太郎','property'=>1001,'body'=>'見学希望','date'=>'2025-12-15'],
          ['id'=>502,'user'=>'佐藤 花子','property'=>1002,'body'=>'料金詳細','date'=>'2025-12-16'],
        ] as $i)
          <tr>
            <td>{{ $i['id'] }}</td>
            <td>{{ $i['user'] }}</td>
            <td>{{ $i['property'] }}</td>
            <td>{{ $i['body'] }}</td>
            <td>{{ $i['date'] }}</td>
            <td class="text-nowrap">
              <a class="btn btn-sm btn-outline-secondary" href="{{ route('properties.show', $i['property']) }}">物件</a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
