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
    Route::resource('affiliate', 'AffiliateController');
    Route::post('/affiliate-list', 'AffiliateController@list')->name('affiliate.list');
    Route::post('/affiliate-change-status/{id}', 'AffiliateController@changeStatus')->name('affiliate.change.status');
});
