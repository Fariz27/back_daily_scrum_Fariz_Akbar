<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::post('login', 'UserController@login');
Route::post('register', 'UserController@register');


Route::group(['middleware' => ['jwt.verify']], function () {
    Route::get('login/check', "UserController@LoginCheck"); //cek token
	Route::post('logout', "UserController@logout"); //cek token
    Route::post('daily/{id}', "DailyController@store"); //cek token
    Route::put('daily/{id}', "DailyController@update"); //cek token
    Route::delete('daily/{id}', "DailyController@delete"); //cek token
    Route::get('daily', "DailyController@index"); //cek token
    Route::get('scrum/{limit}/{offset}', "DailyController@getall"); //cek token
});
