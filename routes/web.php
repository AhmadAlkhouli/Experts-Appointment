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

Route::get('/', function () {
    return view('welcome');
});

Route::get('experts','ExpertsController@index');
Route::get('experts/{id}','ExpertsController@show');

Route::get('experts/{id}/books','BookController@getBooks');

Route::get('experts/{id}/book','ExpertsController@book');
Route::redirect('/', '/experts');