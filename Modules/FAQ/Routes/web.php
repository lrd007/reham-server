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
    Route::resource('/faq', 'FAQController');
    Route::post('/faq-list', 'FAQController@list')->name('faq.list');
    Route::post('/faq-change-status/{id}', 'FAQController@changeStatus')->name('faq.change.status');

    //FAQ Categories
    Route::resource('/category', 'FaqCategoryController');
    Route::post('/category-list', 'FaqCategoryController@list')->name('category.list');
    Route::post('/category-change-status/{id}', 'FaqCategoryController@changeStatus')->name('category.change.status');
});