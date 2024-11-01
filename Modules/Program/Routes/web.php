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
    Route::resource('/program', 'ProgramController');
    Route::post('/program-list', 'ProgramController@list')->name('program.list');
    Route::post('/program/{id}/recover', 'ProgramController@recover')->name('program.recover');

    Route::post('/program-change-status/{id}', 'ProgramController@changeStatus')->name('program.change.status');
    Route::post('/program-change-in-home/{id}', 'ProgramController@changeinHomePage')->name('program.change.in_home_page');
    Route::get('/program-hierarchy/{id}', 'ProgramController@programHierarchy')->name('program.hierarchy');

    //Program section routes
    Route::get('/program-section-index', 'ProgramController@programSectionIndex')->name('program.section.index');
    Route::post('/program-section-list', 'ProgramController@programSectionList')->name('program.section.list');

    Route::get('/program-section-create', 'ProgramController@programSectionCreate')->name('program.section.create');
    Route::get('/program-section/{id}/edit', 'ProgramController@programSectionEdit')->name('program.section.edit');
    Route::post('/program-section', 'ProgramController@programSectionAndElement')->name('program.section.element');
    Route::delete('/program-section/{id}', 'ProgramController@programSectionDelete')->name('program.section.delete');
});

Route::get('/course-by-program-ids', 'ProgramController@courseByProgram')->middleware(['auth']);
