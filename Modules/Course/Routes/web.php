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
    Route::resource('/course', 'CourseController');
    Route::post('/course-list', 'CourseController@list')->name('course.list');
    Route::post('/course/fee', 'CourseController@courseFee')->name('course.fee');
    Route::post('/course/coupon', 'CourseController@courseCoupon')->name('course.coupon');
    Route::post('/course/bonus', 'CourseController@courseBonus')->name('course.bonus');
    Route::post('/course/bonus/{id}/delete', 'CourseController@courseBonusDelete')->name('course.bonus.delete');
    Route::post('/course/bonus/date', 'CourseController@courseBonusDate')->name('course.bonus.date');
    Route::post('/course/get-started', 'CourseController@getStarted')->name('course.get-started');

    Route::post('/course-change-status/{id}', 'CourseController@changeStatus')->name('course.change.status');

    //Course Packages
    Route::resource('/coursepackage', 'CoursePackageController');
    Route::post('/coursepackage-list', 'CoursePackageController@list')->name('coursepackage.list');
    Route::post('/coursepackage-change-status/{id}', 'CoursePackageController@changeStatus')->name('coursepackage.change.status');    

    Route::get('/course-list/filter', 'CourseController@filterForm')->name('course.list.filter');
});

Route::get('/package-by-course-ids', 'CourseController@packageByCourse')->middleware(['auth']);
Route::get('/chapter-by-course-ids', 'CourseController@chapterByCourse')->middleware(['auth']);
