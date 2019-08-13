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

Route::get('/', function () {
    return view('searcher');
});

Route::get('/ingresar', 'ProductController@newProduct')->name('newProduct');
Route::post('/ingresar', 'ProductController@create');
Route::get('success', function () {
    return view('success');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
