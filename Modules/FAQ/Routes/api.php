<?php

use Illuminate\Http\Request;
use Modules\FAQ\Entities\Faq;

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

Route::get('/general_faq', 'ApiController@general_faq');
Route::get('/legal_faq', 'ApiController@legal_faq');