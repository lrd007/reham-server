<?php

use Illuminate\Http\Request;
use Modules\Program\Entities\Program;

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

Route::get('/program_details/{program}', 'ApiController@program_details');
Route::get('/programs', 'ApiController@all_programs');