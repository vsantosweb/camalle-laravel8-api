<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
|
| Here is where you can register CUSTOMER routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('user')->namespace('Api\v1\Backoffice\User')->group(function () {

    Route::prefix('auth')->namespace('Auth')->group(function () {

        Route::post('login', 'UserAuthController@login');

        Route::middleware('auth:user')->group(function () {

            Route::post('logout', 'UserAuthController@logout');
            Route::get('session', 'UserAuthController@session')->middleware('emailVerified');

        });
    });
});
