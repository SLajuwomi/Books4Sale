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

use App\Http\Controllers\SayItController;

Route::get('/', 'SayItController@index');
Route::get('/error', 'SayItController@error');
Route::get('/logout', 'Auth\LoginController@logout')->middleware('auth');
Route::post('/save_message', 'SayItController@save_message')->middleware('auth');
Route::post('/delete_message', 'SayItController@delete_message')->middleware('auth');
Route::post('/message_detail', 'SayItController@message_detail')->middleware('auth');
Route::get('/phpinfo', function () { phpinfo(); });

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
