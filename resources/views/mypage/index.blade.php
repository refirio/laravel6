@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">マイページ</div>

                <div class="card-body">
                    <ul>
                        <li><a href="{{ route('mypage.basis') }}">基本情報編集</a></li>
                        <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">ログアウト</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
