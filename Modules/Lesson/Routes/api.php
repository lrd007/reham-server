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

// Protected APIs.
Route::middleware('auth:sanctum')->group(function () {

    // Lesson Completed API.
    Route::post('/lesson_completed', 'ApiController@lesson_completed');

    // Remove Lesson Completed API.
    Route::post('/remove_lesson_completed', 'ApiController@remove_lesson_completed');

    // Chapter Percentage API.
    Route::post('/chapter_percentage', 'ApiController@chapter_percentage');
});