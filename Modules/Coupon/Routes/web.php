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
    Route::resource('/coupon', 'CouponController');
    Route::post('/coupon-list', 'CouponController@list')->name('coupon.list');
    Route::post('/coupon/{id}/recover', 'CouponController@recover')->name('coupon.recover');

    Route::post('/coupon-change-status/{id}', 'CouponController@changeStatus')->name('coupon.change.status');
});
