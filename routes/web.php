<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', 'Painel@index');
Route::get('/login', 'Painel@login');

//cadastros
Route::get('/cad', 'Painel@cad_geral')->name('cad');
Route::post('/cad', 'Painel@cad_geral')->name('cad_post');

Auth::routes();

Route::get('/home', 'Painel@cad_geral')->name('home');


