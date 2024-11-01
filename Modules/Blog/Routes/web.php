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
    Route::resource('/blog', 'BlogController');
    Route::post('/blog-list', 'BlogController@list')->name('blog.list');

    Route::post('/blog-change-status/{id}', 'BlogController@changeStatus')->name('blog.change.status');
});