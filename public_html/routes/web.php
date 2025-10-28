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
Route::get('/addbook', 'BookController@addbook')->middleware('auth');
Route::get('/logout', 'Auth\LoginController@logout')->middleware('auth');
Route::post('/addbook', 'BookController@postaddbook')->middleware('auth');
// Route::get('/bookdetail', 'BookController@bookdetail')->middleware('auth');
Route::post('/bookdetail', 'BookController@bookdetail')->middleware('auth');
Route::post('/delete_book', 'BookController@delete_book')->middleware('auth');

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
