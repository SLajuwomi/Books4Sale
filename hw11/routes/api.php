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

Route::get('books', 'BookController@get_books');

Route::get('books/{id}', 'BookController@get_book')->middleware('auth:api');
Route::post('books', 'BookController@post_book')->middleware('auth:api');

Route::group(['middleware' => ['auth:api', 'owner']], function() {
    Route::put('books/{id}', 'BookController@put_book');
    Route::delete('books/{id}', 'BookController@delete_book');
});

Route::post('register', 'Auth\RegisterController@register');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout');
