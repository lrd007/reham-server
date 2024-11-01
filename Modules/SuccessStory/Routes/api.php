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

Route::get('/success_story', 'ApiController@success_story_get');

// Protected APIs.
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/success_story', 'ApiController@success_story_post');
});
