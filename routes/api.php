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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', 'AuthController@register')->name('register');

Route::post('token', 'AuthController@getToken')->name('getToken');
Route::post('token/refresh', 'AuthController@refreshToken')->name('refreshToken');


Route::middleware('Auth','ACL')->group(function () {
    Route::post('test', 'HomeController@test')->name('test');
});