<?php

use Illuminate\Http\Request;
use Modules\Course\Entities\Course;
use Modules\Program\Entities\Program;
use Modules\Setting\Entities\Setting;

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
Route::get('/homepage', 'ApiController@homepage');
Route::get('/footer', 'ApiController@footer');
Route::get('/special_courses', 'ApiController@special_courses');
Route::post('/newsletter', 'ApiController@newsletter');
Route::get('/about_us', 'ApiController@about_us');
Route::get('/success_story_guidelines', 'ApiController@success_story_guidelines');
Route::get('/paypal_rate', 'ApiController@paypal_rate');

