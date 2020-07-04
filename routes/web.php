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
