@extends('layouts.app')
@section('title','会員ユーザー管理')

@section('content')
<h1 class="fw-bold mb-3">会員ユーザー管理</h1>

<div class="p-4 bg-white border rounded-4">
  <div class="table-responsive">
    <table class="table table-bordered align-middle">
      <thead class="table-light">
        <tr>
          <th>ID</th>
          <th>氏名</th>
          <th>メール</th>
          <th>区分</th>
          <th>削除</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @foreach([
          ['id'=>1,'name'=>'山田 太郎','email'=>'taro@example.com','role'=>'一般','del'=>'FALSE'],
          ['id'=>2,'name'=>'管理者','email'=>'admin@example.com','role'=>'管理','del'=>'FALSE'],
        ] as $u)
          <tr>
            <td>{{ $u['id'] }}</td>
            <td>{{ $u['name'] }}</td>
            <td>{{ $u['email'] }}</td>
            <td>{{ $u['role'] }}</td>
            <td>{{ $u['del'] }}</td>
            <td class="text-nowrap">
              <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.users.show', $u['id']) }}">詳細</a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
