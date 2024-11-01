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
    Route::resource('/chapter', 'ChapterController');
    Route::post('/chapter-list', 'ChapterController@list')->name('chapter.list');
    Route::post('/chapter/bonus', 'ChapterController@chapterBonus')->name('chapter.bonus');
    Route::post('/chapter/bonus/{id}/delete', 'ChapterController@chapterBonusDelete')->name('chapter.bonus.delete');
    Route::post('/chapter/bonus/date', 'ChapterController@chapterBonusDate')->name('chapter.bonus.date');

    Route::get('/chapter-list/filter', 'ChapterController@filterForm')->name('chapter.list.filter');
    Route::post('/chapter-change-status/{id}', 'ChapterController@changeStatus')->name('chapter.change.status');
});

Route::get('/lesson-by-chapter-ids', 'ChapterController@lessonByChapter')->middleware(['auth']);