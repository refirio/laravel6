<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::post('confirm', 'Auth\RegisterController@confirm')->name('confirm');

Route::get('/home', 'HomeController@index')->name('home');

// 認証後のコンテンツ
Route::group(['middleware' => 'auth'], function () {
    // マイページ
    Route::group(['as' => 'mypage'], function () {
        // マイページ
        Route::get('/mypage', 'MypageController@index')->name('.index');
        // 基本情報編集画面
        Route::get('/mypage/basis', 'MypageController@basis')->name('.basis');
        // 基本情報編集
        Route::post('/mypage/basis_update', 'MypageController@basisUpdate')->name('.basis.update');
    });
});

// 管理者
Route::namespace('Admin')->prefix('admin')->group(function () {
    Route::name('admin.')->group(function () {
        // ログイン認証関連
        Auth::routes([
            'register' => false,
            'reset' => false,
            'verify' => false
        ]);
    });

    // 認証後のコンテンツ
    Route::middleware('auth:admin')->group(function () {
        Route::group(['as' => 'admin'], function () {
            // ダッシュボード
            Route::get('/home', 'HomeController@index')->name('.home');
            // ユーザ管理
            Route::get('/user', 'UserController@index')->name('.user.index');
            Route::get('/user/create', 'UserController@create')->name('.user.create');
            Route::post('/user/create', 'UserController@store')->name('.user.store');
            Route::get('/user/edit/{id}', 'UserController@edit')->name('.user.edit');
            Route::put('/user/edit/{id}', 'UserController@update')->name('.user.update');
            Route::delete('/user/delete/{id}', 'UserController@destroy')->name('.user.delete');
            // 記事管理
            Route::get('/entry', 'EntryController@index')->name('.entry.index');
            Route::get('/entry/create', 'EntryController@create')->name('.entry.create');
            Route::post('/entry/create', 'EntryController@store')->name('.entry.store');
            Route::get('/entry/edit/{id}', 'EntryController@edit')->name('.entry.edit');
            Route::put('/entry/edit/{id}', 'EntryController@update')->name('.entry.update');
            Route::delete('/entry/delete/{id}', 'EntryController@destroy')->name('.entry.delete');
            // カテゴリ管理
            Route::get('/category', 'CategoryController@index')->name('.category.index');
            Route::get('/category/create', 'CategoryController@create')->name('.category.create');
            Route::post('/category/create', 'CategoryController@store')->name('.category.store');
            Route::get('/category/edit/{id}', 'CategoryController@edit')->name('.category.edit');
            Route::put('/category/edit/{id}', 'CategoryController@update')->name('.category.update');
            Route::delete('/category/delete/{id}', 'CategoryController@destroy')->name('.category.delete');
        });
    });
});
