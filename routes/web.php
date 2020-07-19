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
        });
    });
});
