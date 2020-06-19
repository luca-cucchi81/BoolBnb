<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('messages/{user_id}', 'Api\MessageController@getAll');
Route::get('visits/{user_id}', 'Api\VisitsController@getAll');
Route::get('visits/apartment/{apartment_id}', 'Api\VisitsController@getPeriods');
Route::get('sponsorships/{user_id}', 'Api\SponsorshipController@getAll');
Route::get('apartments', 'Api\ApartmentController@getAll');
