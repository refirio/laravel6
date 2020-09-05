@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">管理者用ページ</div>

                <div class="card-body">
                    <ul>
                        <li><a href="{{ route('admin.home') }}">ホーム</a></li>
                        <li><a href="{{ route('admin.user.index') }}">ユーザ管理</a></li>
                        <li><a href="{{ route('admin.entry.index') }}">記事管理</a></li>
                        <li><a href="{{ route('admin.category.index') }}">カテゴリ管理</a></li>
                        <li><a href="{{ route('admin.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">ログアウト</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
