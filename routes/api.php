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
    Route::get('/contacts', 'ContactController@index');
    Route::post('/contacts', 'ContactController@store');
    Route::get('/contacts/{contact}', 'ContactController@show');
    Route::put('/contacts/{contact}', 'ContactController@update');
    Route::delete('/contacts/{contact}', 'ContactController@destroy');
    Route::get('/shippers', 'ShipperController@index');
    Route::post('/shippers', 'ShipperController@store');
    Route::get('/shippers/{shipper-id}', 'ShipperController@show');
    Route::put('/shippers/{shipper-id}', 'ShipperController@update');
    Route::delete('/shippers/{shipper-id}', 'ShipperController@destroy');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
