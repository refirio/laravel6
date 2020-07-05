@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">ユーザ一覧</div>
                <div class="card-body">
                    <ul>
                        <li><a href="{{ route('admin.user.create') }}">ユーザ登録</a></li>
                    </ul>
                    <table class="table table-striped">
                        <thead>
                            <th>名前</th>
                            <th>メール</th>
                            <th>削除</th>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td class="table-text"><div>{{ $user->name }}</div></td>
                                <td class="table-text"><div>{{ $user->email }}</div></td>

                                <td>
                                    <form action="{{ url('admin/user/' . $user->id) }}" method="POST">
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
