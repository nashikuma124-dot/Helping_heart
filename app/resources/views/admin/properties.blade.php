@extends('layouts.app')
@section('title','物件データ管理')

@section('content')
<h1 class="fw-bold mb-3">物件データ管理</h1>

<div class="p-4 bg-white border rounded-4">
  <div class="d-flex flex-wrap gap-2 mb-3">
    <a class="btn btn-primary" href="#">新規登録（仮）</a>
    <a class="btn btn-outline-secondary" href="{{ route('admin.dashboard') }}">管理者トップ</a>
  </div>

  <div class="table-responsive">
    <table class="table table-bordered align-middle">
      <thead class="table-light">
        <tr>
          <th>ID</th>
          <th>物件名</th>
          <th>公開</th>
          <th>空室</th>
          <th>更新日</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @foreach([
          ['id'=>1001,'name'=>'物件A','pub'=>'公開','vac'=>'あり','date'=>'2025-12-01'],
          ['id'=>1002,'name'=>'物件B','pub'=>'非公開','vac'=>'なし','date'=>'2025-11-20'],
        ] as $p)
          <tr>
            <td>{{ $p['id'] }}</td>
            <td>{{ $p['name'] }}</td>
            <td>{{ $p['pub'] }}</td>
            <td>{{ $p['vac'] }}</td>
            <td>{{ $p['date'] }}</td>
            <td class="text-nowrap">
              <a class="btn btn-sm btn-outline-secondary"
                 href="{{ route('admin.properties.show', $p['id']) }}">詳細</a>
              <a class="btn btn-sm btn-outline-secondary"
                 href="{{ route('admin.properties.edit', $p['id']) }}">編集</a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
