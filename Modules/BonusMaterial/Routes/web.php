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
    Route::resource('/bonusmaterial', 'BonusMaterialController');
    Route::post('/bonusmaterial-list', 'BonusMaterialController@list')->name('bonusmaterial.list');

    Route::post('/bonusmaterial/bonus', 'BonusMaterialController@bonusmaterialBonus')->name('bonusmaterial.bonus');
    Route::post('/bonusmaterial/bonus/{id}/delete', 'BonusMaterialController@bonusmaterialBonusDelete')->name('bonusmaterial.bonus.delete');
    Route::post('/bonusmaterial/bonus/date', 'BonusMaterialController@bonusmaterialBonusDate')->name('bonusmaterial.bonus.date');

    Route::post('/bonusmaterial-change-status/{id}', 'BonusMaterialController@changeStatus')->name('bonusmaterial.change.status');
});