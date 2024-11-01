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
    Route::resource('/comment', 'CommentController');
    Route::post('/comment-list', 'CommentController@list')->name('comment.list');

    Route::post('/comment-change-status/{id}', 'CommentController@changeStatus')->name('comment.change.status');
});
