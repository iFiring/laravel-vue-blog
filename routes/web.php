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

// 主页
Route::get('', function () {
    return view('welcome');
});

// 博客主页
Route::get('blog', 'BlogController@index');
Route::get('articles', 'BlogController@list');
Route::get('articles/{id}', 'BlogController@show');
Route::get('sorts', 'BlogController@sorts');

// Auth
Route::namespace('Auth')->group(function () {
    Route::post('login', 'LoginController@login');
    Route::get('logout', 'LoginController@logout');
});

// 后台管理Api
Route::middleware('auth')->prefix('api')->namespace('Admin')->group(function (){
    Route::get('articles', 'ArticleController@index');
    Route::get('articles/{id}', 'ArticleController@show');
    Route::post('article', 'ArticleController@create');
    Route::put('articles/{id}', 'ArticleController@update');
    Route::patch('articles/{id}', 'ArticleController@publish');
    Route::delete('articles/{id}', 'ArticleController@destroy');

    Route::get('sorts', 'SortController@index');
    Route::post('sorts', 'SortController@create');
    Route::patch('sorts/{id}', 'SortController@update');
    Route::delete('sorts/{id}', 'SortController@destroy');

    Route::post('file/image', 'FileController@uploadImage');
    Route::delete('file/image', 'FileController@deleteImage');

    Route::get('user_info', 'UserController@currentUserInfo');
});
