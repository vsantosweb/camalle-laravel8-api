<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| RESPONDENT Routes
|--------------------------------------------------------------------------
|
| Here is where you can register RESPONDENT routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('respondent')->namespace('Api\v1\Client\Respondent')->group(function () {
    Route::prefix('auth')->namespace('Auth')->group(function () {
        Route::prefix('register')->group(function () {
            // Route::post('/', 'RespondentRegisterController@register');
        });
        // Route::post('login', 'RespondentAuthController@login');

        Route::middleware('auth:Respondent,Respondent-token')->group(function () {
            // Route::get('logged', 'RespondentAuthController@logged');
            // Route::post('logout', 'RespondentAuthController@logout');
        });
    });

    Route::prefix('session')->group(function () {
        Route::get('/{token}', 'RespondentDiscSessionController@checkSession');
        Route::post('shutdown', 'RespondentDiscSessionController@hashLogout');
    });

    Route::get('disc/{code}', 'RespondentController@getTest');
});
