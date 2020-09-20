@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">記事 @if (!Request::is('*/create')) {{ '編集' }} @else {{ '登録' }} @endif</div>

                <div class="card-body">
                    @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                        {{ $error }}<br>
                        @endforeach
                    </div>
                    @endif

                    <form action="{{ Request::is('*/create') ? route('admin.entry.create') : route('admin.entry.edit', ['id' => $entry->id]) }}" method="POST" class="form-horizontal">
                        @if (!Request::is('*/create'))
                            {{ method_field('put') }}
                        @endif
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="datetime" class="col-sm-3 control-label">日時</label>

                            <div class="col-sm-6">
                                <input type="text" name="datetime" id="datetime" class="form-control" value="{{ old('datetime', isset($entry) ? $entry->datetime : '') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="title" class="col-sm-3 control-label">タイトル</label>

                            <div class="col-sm-6">
                                <input type="text" name="title" id="title" class="form-control" value="{{ old('title', isset($entry) ? $entry->title : '') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="body" class="col-sm-3 control-label">本文</label>

                            <div class="col-sm-12">
                                <textarea name="body" id="body" rows="10" cols="10" class="form-control">{{{ old('body', isset($entry) ? $entry->body : '') }}}</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">カテゴリ</label>

                            <div class="col-sm-6">
                                @foreach ($categories as $category)
                                <div>
                                    <label class="control-label conditions"><input type="checkbox" name="categories[]" value="{{ $category->id }}" @if (in_array($category->id, old('categories', isset($entry) ? $entry_categories : []))) checked @endif> {{ $category->name }}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="user_id" class="col-sm-3 control-label">ユーザ</label>

                            <div class="col-sm-6">
                                <select name="user_id" class="form-control">
                                    <option value=""></option>
                                    @foreach ($users as $user)
                                    <option value="{{ $user->id }}" @if (old('user_id', isset($entry) ? $entry->user_id : '') == $user->id) selected @endif>{{ $user->name }}</option>
                                    @endforeach
                                </select>
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
