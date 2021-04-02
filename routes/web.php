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

use App\Http\Controllers\UsuarioController;

Route::get('/', 'UsuarioController@index');

Route::get('/users/create', 'UsuarioController@create');

Route::get('/users/login', 'UsuarioController@login');

Route::post('/users', 'UsuarioController@store');