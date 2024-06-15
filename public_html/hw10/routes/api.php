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
Route::get('books/{id}', 'BookController@get_book');
Route::post('books', 'BookController@post_book');
Route::put('books/{id}', 'BookController@put_book');
Route::delete('books/{id}', 'BookController@delete_book');
