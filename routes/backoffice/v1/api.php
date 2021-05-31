<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| CUSTOMER Routes
|--------------------------------------------------------------------------
|
| Here is where you can register CUSTOMER routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::middleware('auth:user')->group(function(){
    
    Route::namespace('Api\v1\Backoffice\Customer')->group(function () {
        Route::get('customer/online', 'CustomerController@online');
        Route::resource('customers', 'CustomerController');
        Route::resource('customer/types', 'CustomerTypeController');
    
    });

    Route::namespace('Api\v1\Backoffice\Disc\Plan')->group(function () {
        Route::resource('customer/subscriptions', 'DiscPlanSubscriptionController');
        Route::put('customer/subscription/additional-credits', 'DiscPlanSubscriptionController@storeAdditionalsCredits');

        Route::resource('disc-plans', 'DiscPlanController');
    });
    
});



