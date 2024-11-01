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
    Route::resource('/payment', 'PaymentController');
    Route::post('/payment-list', 'PaymentController@list')->name('payment.list');
    Route::get('/payment-list/enrollment/filter', 'PaymentController@filterForm')->name('payment.enrollment.filter');
    Route::get('/payment-list/enrollment/excel', 'PaymentController@exportExcel')->name('payment-list.enrollment.excel');
    Route::get('/payment-list/enrollment/pdf', 'PaymentController@exportPDF')->name('payment-list.enrollment.pdf');

});
