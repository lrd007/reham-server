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
    Route::resource('/audiobook', 'AudioBookController');
    Route::post('/audiobook-list', 'AudioBookController@list')->name('audiobook.list');

    Route::post('/audiobook-change-status/{id}', 'AudioBookController@changeStatus')->name('audiobook.change.status');
});