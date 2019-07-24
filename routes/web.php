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


Route::get('/t', 'PostController@index');

Route::get('/', 'HomeController@index');
Route::get('/search','PostController@search');

Route::get('/song', 'CrudController@create')->name('song');
Route::get('/author', 'AuthorController@create')->name('author');

Route::resource('posts','PostController');
Route::resource('cruds','CrudController');
Route::resource('authors','AuthorController');

// Route::get('/login','CrudController@getLogin');
// Route::post('/login','CrudController@postLogin');

// Route::get('login','LoginController@getLogin');
// Route::post('login','LoginController@postLogin');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');