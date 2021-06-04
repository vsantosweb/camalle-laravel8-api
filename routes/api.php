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

Route::prefix('v1')->namespace('Api\v1')->group(function () {

    Route::prefix('webhook')->namespace('Disc')->group(function () {

        // Route::get('message', 'DiscQuestionsController@index');
    });

    Route::get('/swagger.json', function () { return response()->json(json_decode(file_get_contents(public_path('swagger-doc.json'))), 200)
        ->header('access-control-allow-methods', 'GET, POST, DELETE, PUT')
        ->header('access-control-allow-origin', '*')
        ->header('Access-Control-Allow-Headers', 'Content-Type, api_key, Authorization'); });
});
