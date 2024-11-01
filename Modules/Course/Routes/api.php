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

Route::get('/course_detail/{course}', 'ApiController@course_detail');
Route::get('/search_courses', 'ApiController@search_courses');
Route::get('/lesson_comments', 'ApiController@lesson_comments');
Route::get('/course_comments', 'ApiController@course_comments');
Route::get('/bonus_material_comments', 'ApiController@bonus_material_comments');
Route::get('/suggested_courses', 'ApiController@suggested_courses');
Route::get('/all_courses', 'ApiController@all_courses');


