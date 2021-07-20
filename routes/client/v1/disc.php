<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| DISC Routes
|--------------------------------------------------------------------------
|
| Here is where you can register DISC routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('disc')->namespace('Api\v1\Client\Disc')->group(function () {

    Route::prefix('sessions')->group(function () {
        Route::post('/start', 'DiscSessionController@start');
        Route::post('/finish', 'DiscSessionController@finish');
    });

    Route::prefix('questions')->group(function () {
        Route::get('/', 'DiscQuestionsController@index');
        Route::get('/{uuid}', 'DiscQuestionsController@show');
    });

    Route::get('intensities', 'DiscController@intensities');
    Route::get('disc-intensities', 'DiscController@discIntensities');

});
