<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'BookController@index');
Route::get('/error', 'BookController@error');
Route::get('/addbook', 'BookController@addbook');
Route::POST('/addbook', 'BookController@postaddbook');
Route::get('/bookdetail', 'BookController@bookdetail');
Route::POST('/delete_book', 'BookController@delete_book');
