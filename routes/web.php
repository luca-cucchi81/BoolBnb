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

Route::get('/', 'ApartmentController@index')->name('guest.apartments.index');

Route::prefix('admin')
->namespace('Admin')
->name('admin.')
->middleware('auth')
->group(function(){
    Route::resource('apartments', 'ApartmentController');
    Route::resource('users', 'UserController');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
