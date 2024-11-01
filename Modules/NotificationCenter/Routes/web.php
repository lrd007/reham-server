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
    Route::resource('/notificationcenter', 'NotificationCenterController');
    Route::post('/notificationcenter-list', 'NotificationCenterController@list')->name('notificationcenter.list');
    Route::post('/send-notification/{id}', 'NotificationCenterController@sendNotification')->name('notificationcenter.send');
});



