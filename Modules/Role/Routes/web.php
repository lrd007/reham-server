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
    Route::resource('/role', 'RoleController');
    Route::post('/role-list', 'RoleController@list')->name('role.list');
    Route::post('/role/{id}/recover', 'RoleController@recover')->name('role.recover');
});
