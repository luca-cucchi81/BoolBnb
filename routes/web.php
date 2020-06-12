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

Route::get('/payment/make', 'PaymentsController@make')->name('payment.make');

Route::get('/', 'ApartmentController@index')->name('guest.apartments.index');
Route::get('/search', 'ApartmentController@search')->name('guest.apartments.search');

Route::prefix('admin')
->namespace('Admin')
->name('admin.')
->middleware('auth')
->group(function(){
    Route::resource('apartments', 'ApartmentController');
    Route::resource('users', 'UserController');
    Route::get('sponsor/{apartment}','ApartmentController@sponsor')->name('apartments.sponsor');
    Route::get('apartments/process','ApartmentController@process')->name('apartments.process');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
