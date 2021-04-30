<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () { return response()->json([]); });


Route::get('login', function(){ return response()->json('401 Unauthorized', 401); })->name('login');
Route::get('email-verified', function(){ return response()->json('Email verification required', 401); })->name('email-verified');