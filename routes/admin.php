<?php


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/


Route::get('/','HomeController@index');

Route::get('users/new','UserController@newUsers');
Route::get('users/active','UserController@active');
Route::resource('users','UserController');

Route::get('videos-most-viewed','VideoController@most');
Route::get('videos-latest','VideoController@latest');
Route::get('images-most-viewed','ImageController@most');
Route::get('images-latest','ImageController@latest');



Route::resource('images','ImageController');
Route::resource('videos','VideoController');

Route::get('settings','SettingsController@show');
Route::post('settings/update','SettingsController@update');