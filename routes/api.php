<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// 博客API
Route::get('articles', 'BlogController@list');
Route::get('articles/{id}', 'BlogController@show');
Route::get('sorts', 'BlogController@sorts');

// Auth
Route::namespace('Auth')->prefix('admin')->group(function () {
    Route::post('login', 'LoginController@login');
    Route::get('logout', 'LoginController@logout');
});

// 后台管理Api
Route::middleware('auth:api')->prefix('admin')->namespace('Admin')->group(function (){
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

    Route::get('user', 'UserController@currentUserInfo');
});

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
