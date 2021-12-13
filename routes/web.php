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

Route::get('/', 'LandingController@index');

Route::get('/login', 'LandingController@index');
Route::post('/login', 'LandingController@postLogin');
Route::get('/logout', 'LandingController@logout');

// Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');

Route::group(['prefix' => 'menu'], function () {
	Route::get('/menu', 'MenuController@menuall');
	Route::post('/form/tambahmenu', 'MenuController@forminsertmenu');
	Route::post('/form/ubahmenu', 'MenuController@formupdatemenu');
	Route::post('/form/hapusmenu', 'MenuController@formdeletemenu');
	Route::get('/menuakses', 'MenuController@menuakses');
	Route::post('/form/ubahaccess', 'MenuController@formupdateaccess');
});