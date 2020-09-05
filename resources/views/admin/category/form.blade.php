@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">カテゴリ @if (!Request::is('*/create')) {{ '編集' }} @else {{ '登録' }} @endif</div>

                <div class="card-body">
                    @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                        {{ $error }}<br>
                        @endforeach
                    </div>
                    @endif

                    <form action="{{ Request::is('*/create') ? route('admin.category.create') : route('admin.category.edit', ['id' => $category->id]) }}" method="POST" class="form-horizontal">
                        @if (!Request::is('*/create'))
                            {{ method_field('put') }}
                        @endif
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="name" class="col-sm-3 control-label">名前</label>

                            <div class="col-sm-6">
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', isset($category) ? $category->name : '') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="sort" class="col-sm-3 control-label">並び順</label>

                            <div class="col-sm-6">
                                <input type="text" name="sort" id="sort" class="form-control" value="{{ old('sort', isset($category) ? $category->sort : '') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-plus"></i>@if (!Request::is('*/create')) {{ '編集' }} @else {{ '登録' }} @endif
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
