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

Route::get('messages', 'SayItcontroller@get_messages');

Route::get('messages/{id}', 'SayItcontroller@get_message')->middleware('auth:api');
Route::post('messages', 'SayItcontroller@post_message')->middleware('auth:api');

Route::group(['middleware' => ['auth:api', 'owner']], function() {
    Route::put('messages/{id}', 'SayItcontroller@put_message');
    Route::delete('messages/{id}', 'SayItcontroller@delete_message');
});


Route::post('register', 'Auth\RegisterController@register');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout');
