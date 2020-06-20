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


Route::get('/', 'ApartmentController@index')->name('guest.apartments.index'); // Rotta Home page del sito
Route::get('/search', 'ApartmentController@search')->name('guest.apartments.search'); // Rotta alla pagina di ricerca
Route::get('/home', 'HomeController@index')->name('home'); // Rotta alla Home di un Utente Loggato

Route::prefix('admin') // Insieme di rotte di un Utente Loggato
->namespace('Admin')
->name('admin.')
->middleware('auth')
->group(function(){
    Route::resource('apartments', 'ApartmentController'); // CRUD Appartamenti
    Route::resource('users', 'UserController'); // CRUD Utenti
    Route::resource('messages', 'MessageController'); // CRUD Messaggi
    Route::get('sponsor/{apartment}','ApartmentController@sponsor')->name('apartments.sponsor'); // Rotta per la sponsorizzazione
    Route::post('apartments/sponsorships', 'ApartmentController@pivot')->name('apartments.pivot'); // Rotta creazione sponsorizzazione
    Route::get('/payment/make', 'PaymentController@make')->name('payment.make'); // Rotta pagamento sponsorizzazione
});

Route::prefix('guest') // Rotte Guest
->name('guest.')
->group(function(){
    Route::resource('apartments', 'ApartmentController');
});

Auth::routes(); // CRUD Rotte autenticazione
