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

Route::get('/search', 'ProductController@search')->middleware('auth')->name('search');
    
Route::get('/search/action', 'ProductController@action')->middleware('auth')->name('search.action');

Route::get('/update', 'ProductController@viewUpdate')->middleware('auth')->name('update');

Route::post('update', 'ProductController@update')->middleware('auth');

Route::get('/update/asd', 'ProductController@update')->middleware('auth')->name('update.product');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//UPDATE
//Route::get('/', 'ImportController@getImport')->name('import');
Route::post('/import_parse', 'ImportController@parseImport')->name('import_parse');
Route::post('/import_process', 'ImportController@processImport')->name('import_process');


Route::group(['middleware' => 'auth'], function () {
    // User needs to be authenticated to enter here.
    Route::get('/search', 'ProductController@search')->name('search');
    
    Route::get('/configuration', 'ProductController@configuration')->name('configuration');
    Route::get('/search/action', 'ProductController@action')->name('search.action');
    
    Route::group(['prefix' => 'providers'], function () {
        Route::get('/create', 'ProviderController@create')->name('providers.create');
    });
    Route::get('/update', 'ProductController@viewUpdate')->name('update');
    
    Route::post('update', 'ProductController@update');
    
    Route::get('/update/asd', 'ProductController@update')->name('update.product');
    
    Route::get('user/profile', function () {
        // Uses Auth Middleware
    });
});