@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">ユーザ一覧</div>
                <div class="card-body">
                    @if (session('message'))
                    <div class="box">
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    </div>
                    @elseif (session('error'))
                    <div class="box">
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    </div>
                    @endif
                    <p><a href="{{ route('admin.user.create') }}" class="btn btn-primary">ユーザ登録</a></p>
                    <table class="table table-striped">
                        <thead>
                            <th>名前</th>
                            <th>メール</th>
                            <th>編集</th>
                            <th>削除</th>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td class="table-text"><div>{{ $user->name }}</div></td>
                                <td class="table-text"><div>{{ $user->email }}</div></td>
                                <td class="table-text"><a href="{{ route('admin.user.edit', ['id' => $user->id]) }}" class="btn btn-primary">Edit</a></td>
                                <td>
                                    <form action="{{ route('admin.user.delete', ['id' => $user->id]) }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button type="submit" class="btn btn-danger">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
