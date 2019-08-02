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

Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('messages', 'ChatController@messages');

    Route::post('messages', 'MessageController@store');

    Route::post('file', 'MessageController@upload');
    Route::post('logout', 'ChatController@logout');
});

Route::post('login', 'ChatController@login');
