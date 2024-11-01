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

use App\Mail\SendMail;
use Illuminate\Http\Request;

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/subscriber/by-email', 'SubscriberController@getByEmail');

    Route::resource('/subscriber', 'SubscriberController');
    Route::post('/subscriber-list', 'SubscriberController@list')->name('subscriber.list');
    Route::post('/subscriber-change-status/{id}', 'SubscriberController@changeStatus')->name('subscriber.change.status');


    Route::post('/subscriber-program-list/{id}', 'SubscriberController@subscriberProgramlist')->name('subscriber.program.list');
    Route::get('/subscriber/{id}/program/create', 'SubscriberController@programCreate')->name('subscriber.program.create');
    Route::post('/subscriber/{id}/program/store', 'SubscriberController@programStore')->name('subscriber.program.store');
    Route::get('/subscriber/program/{id}/edit', 'SubscriberController@programEdit')->name('subscriber.program.edit');
    Route::put('/subscriber/{id}/program/update', 'SubscriberController@programUpdate')->name('subscriber.program.update');
    Route::delete('/subscriber/{id}/program/delete', 'SubscriberController@programDestroy')->name('subscriber.program.destroy');
    Route::get('/subscriber-program-hierarchy/{id}', 'SubscriberController@programHierarchy')->name('subscriber.program.hierarchy');

    Route::get('/subscriber/enrollment/filter', 'SubscriberController@filterForm')->name('subscriber.enrollment.filter');
    Route::get('/subscriber/enrollment/excel', 'SubscriberController@exportExcel')->name('subscriber.enrollment.excel');
    Route::get('/subscriber/enrollment/pdf', 'SubscriberController@exportPDF')->name('subscriber.enrollment.pdf');

    Route::post('/subscriber/send-mail', function (Request $request) {
        \Mail::to($request->email)->send(new SendMail($request->all()));
        return true;
    });
});
