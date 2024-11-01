<?php

use Illuminate\Http\Request;

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

// Route::middleware('auth:api')->get('/notificationcenter', function (Request $request) {
//     return $request->user();
// });

// Route::get('/notifications', function () {
  
// });

// Protected APIs.
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/notifications', 'ApiController@get_user_notifications');
    Route::post('/technical_support', 'ApiController@technical_support');
});
