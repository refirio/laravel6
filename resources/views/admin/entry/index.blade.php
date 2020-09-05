@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">記事一覧</div>
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
                    <p><a href="{{ route('admin.entry.create') }}" class="btn btn-primary">記事登録</a></p>
                    <table class="table table-striped">
                        <thead>
                            <th>日時</th>
                            <th>タイトル</th>
                            <th>編集</th>
                            <th>削除</th>
                        </thead>
                        <tbody>
                            @foreach ($entries as $entry)
                            <tr>
                                <td class="table-text"><div>{{ $entry->datetime->format('Y/m/d H:i:s') }}</div></td>
                                <td class="table-text"><div>{{ $entry->title }}</div></td>
                                <td class="table-text"><a href="{{ route('admin.entry.edit', ['id' => $entry->id]) }}" class="btn btn-primary">Edit</a></td>
                                <td>
                                    <form action="{{ route('admin.entry.delete', ['id' => $entry->id]) }}" method="POST">
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
