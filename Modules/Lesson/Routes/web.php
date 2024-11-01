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

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('admin')->group(function() {
    Route::resource('/lesson', 'LessonController');
    Route::post('/lesson-list', 'LessonController@list')->name('lesson.list');
    Route::post('/lesson/bonus', 'LessonController@lessonBonus')->name('lesson.bonus');
    Route::post('/lesson/bonus/{id}/delete', 'LessonController@lessonBonusDelete')->name('lesson.bonus.delete');
    Route::post('/lesson/bonus/date', 'LessonController@lessonBonusDate')->name('lesson.bonus.date');

    Route::get('/lesson-list/filter', 'LessonController@filterForm')->name('lesson.list.filter');

    Route::post('/lesson-change-status/{id}', 'LessonController@changeStatus')->name('lesson.change.status');
});
