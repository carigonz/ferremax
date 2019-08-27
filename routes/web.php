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
    return view('welcome');
});

Route::get('/ingresar', 'ProductController@newProduct')->middleware('auth')->name('newProduct');
Route::post('/ingresar', 'ProductController@create')->middleware('auth');
Route::get('success', function () {
    return view('success');
})->middleware('auth'); 
Route::get('/search', function () {
    return view('searcher');})->middleware('auth')->name('search');
Route::get('/search/action', 'ProductController@action')->middleware('auth')->name('search.action');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
