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
Auth::routes();

Route::get('/', 'SceneController@pannellum')->name('welcome');
Route::get('/admin', 'HomeController@index')->name('home')->middleware('auth');
Route::get('/konfigurasi', 'SceneController@index')->name('scene')->middleware('auth');
Route::get('/profile', 'UserController@index')->name('profil')->middleware('auth');

Route::post('/addScene', 'SceneController@store')->name('addScene')->middleware('auth');
Route::post('/addHotspot', 'HotspotController@store')->name('addHotspot')->middleware('auth');

Route::get('/showScene/{id}', 'SceneController@show')->name('showScene')->middleware('auth');
Route::get('/showHotspot/{id}', 'HotspotController@show')->name('showHotspot')->middleware('auth');

Route::put('/editScene/{id}', 'SceneController@update')->name('editScene')->middleware('auth');
Route::put('/editHotspot/{id}', 'HotspotController@update')->name('editHotspot')->middleware('auth');
Route::put('/editprofile/{id}', 'UserController@update')->name('editProfil')->middleware('auth');
Route::put('/setFScene/{id}', 'SceneController@status')->middleware('auth');

Route::delete('/delUser/{id}', 'UserController@destroy')->name('delProfil')->middleware('auth');
Route::delete('/delScene/{id}', 'SceneController@destroy')->name('delScene')->middleware('auth');
Route::delete('/delHotspot/{id}', 'HotspotController@destroy')->name('delHotspot')->middleware('auth');
