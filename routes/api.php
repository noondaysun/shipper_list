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


Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\V1'], function () {
    Route::post('/auth/signin', 'AuthController@signin');
    Route::get('/contacts', 'ContactController@index');
    Route::post('/contacts', 'ContactController@store')->middleware(['auth:sanctum']);
    Route::get('/contacts/{contact-id}', 'ContactController@show')->name('contacts.show');
    Route::put('/contacts/{contact-id}', 'ContactController@update')->middleware(['auth:sanctum']);
    Route::delete('/contacts/{contact-id}', 'ContactController@destroy')->middleware(['auth:sanctum']);
    Route::get('/shippers', 'ShipperController@index');
    Route::post('/shippers', 'ShipperController@store')->middleware(['auth:sanctum']);
    Route::get('/shippers/{shipper-id}', 'ShipperController@show')->name('shippers.show');
    Route::put('/shippers/{shipper-id}', 'ShipperController@update')->middleware(['auth:sanctum']);
    Route::delete('/shippers/{shipper-id}', 'ShipperController@destroy')->middleware(['auth:sanctum']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
