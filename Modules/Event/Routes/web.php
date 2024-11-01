<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth'])->prefix('admin')->group(function() {
    Route::resource('/event', 'EventController');
    Route::post('/event-list', 'EventController@list')->name('event.list');
    Route::post('/event-change-status/{id}', 'EventController@changeStatus')->name('event.change.status');
});
