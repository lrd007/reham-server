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
    Route::get('/like', 'ApiController@like');
    Route::get('/unlike', 'ApiController@unlike');
    Route::post('/post_comment', 'ApiController@post_comment');
});

Route::post('/add_page_comment', 'ApiController@add_page_comment');
Route::get('/all_page_comments', 'ApiController@all_page_comments');
