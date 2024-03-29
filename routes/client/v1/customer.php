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

Route::prefix('customer')->namespace('Api\v1\Client\Customer')->group(function () {

    Route::prefix('auth')->namespace('Auth')->group(function () {

        Route::post('password/forget', 'CustomerForgotPasswordController@forget');
        Route::post('password/reset', 'CustomerResetPasswordController@reset');
        Route::get('password/reset', 'CustomerResetPasswordController@verifyResetToken');

        Route::post('login', 'CustomerAuthController@login');
        Route::post('register', 'CustomerRegisterController@register');
        Route::post('email/verify', 'CustomerVerificationController@verify');
        Route::post('email/resend', 'CustomerVerificationController@resend');

        Route::get('customer-types', 'CustomerRegisterController@customerTypes');

        Route::middleware('auth:customer')->group(function () {


            Route::post('logout', 'CustomerAuthController@logout');
            Route::get('logged', 'CustomerAuthController@logged')->middleware('emailVerified');
        });
    });

    Route::middleware(['auth:customer', /*emailVerified */])->group(function () {

        Route::prefix('profile')->group(function () {

            Route::get('show', 'CustomerProfileController@showProfile');
            Route::patch('update', 'CustomerProfileController@updateProfile');
            Route::put('change-password', 'CustomerProfileController@changePassword');
            Route::post('api-token', 'CustomerProfileController@generateApicredential');
        });

        Route::prefix('subscription')->group(function () {

            Route::get('/', 'CustomerSubscriptionController@showSubscription');
            Route::get('/consumation', 'CustomerSubscriptionController@consumation');
            Route::patch('update', 'CustomerProfileController@updateProfile');
            Route::put('change-password', 'CustomerProfileController@changePassword');
        });

        Route::resource('messages', 'CustomerMessageController');
        Route::resource('respondents', 'CustomerRespondentController');
        Route::post('respondent-lists/upload', 'CustomerRespondentListController@uploadFile');
        Route::resource('respondent-lists', 'CustomerRespondentListController');

        Route::prefix('reports')->group(function () {
            Route::get('view/{code}', 'CustomerDiscController@show');
            Route::post('create-to-lists', 'CustomerDiscController@createToLists');
            Route::post('create-to-respondent', 'CustomerDiscController@createToSingleRespondent');
            Route::get('queues', 'CustomerDiscController@queues');
            Route::get('filter', 'CustomerDiscController@filter');
            Route::get('session/{code}', 'CustomerDiscController@getQuizSession');
        });

        Route::prefix('settings')->group(function () {
            Route::resource('custom-fields', 'CustomerRespondentCustomFieldController');
        });

        Route::prefix('notifications')->group(function () {
            Route::get('/', 'CustomerNotificationController@index');
            Route::get('/unread', 'CustomerNotificationController@unread');
            Route::put('read/{id}', 'CustomerNotificationController@read');
            Route::post('/read-all', 'CustomerNotificationController@readAll');
            Route::delete('/delete', 'CustomerNotificationController@delete');
        });
    });
});

/*
|--------------------------------------------------------------------------
| CUSTOMER INTEGRATION Routes
|--------------------------------------------------------------------------
|
| Here is where you can register CUSTOMER routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::namespace('Api\v1\Client\Customer')->group(function () {

    Route::middleware('auth:customer-integration')->group(function () {
        Route::post('generate-quiz', 'CustomerDiscController@createToSingleRespondent');
    });

    Route::get('consult-report', 'CustomerDiscController@consultReport');
});

// Route::middleware('auth:customer-integration')->group(function() {
//     Route::post('generate-quiz', 'CustomerDiscController@createToSingleRespondent');
// });