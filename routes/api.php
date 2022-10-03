<?php

use Illuminate\Http\Request;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/messages','MessageController@store');
Route::get('/messages','MessageController@index');

/*
Route::prefix('messages')->middleware('auth:api')->group(function(){
    Route::post('/','MessageController@store');
});
*/
Route::get('/users', 'UserController@index');