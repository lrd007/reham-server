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
    Route::resource('/quiz', 'QuizController');
    Route::post('/quiz-list', 'QuizController@list')->name('quiz.list');
    Route::post('/quiz/{id}/recover', 'QuizController@recover')->name('quiz.recover');
    Route::post('/quiz/question', 'QuizController@storeQuestion')->name('quiz.store.question');

    Route::get('/quiz/export/excel', 'QuizController@exportExcel')->name('quiz.export.excel');
    Route::get('/quiz/export/pdf', 'QuizController@exportPDF')->name('quiz.export.pdf');

    Route::post('/quiz-change-status/{id}', 'QuizController@changeStatus')->name('quiz.change.status');
});
