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

//aqui nas rotas pode chamar uma funçao ou uma view
Route::get('/', 'Painel@index');
Route::get('/login', 'Painel@login');

// //emprendimento geral
// Route::get('/emp', 'Painel@emp_todos')->name('emp');
// Route::post('/emp', 'Painel@emp_todos');
