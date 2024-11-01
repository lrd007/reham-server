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
    Route::get('landing-preview', 'SettingController@landingPreview')->name('landing.preview');
    Route::get('subscriber-page-preview', 'SettingController@subscriberPagePreview')->name('subscriber-page.preview');
    Route::get('suggested-course-preview', 'SettingController@suggestedCoursePreview')->name('suggested-course.preview');
    Route::resource('site-configuration', 'SettingController');
});
