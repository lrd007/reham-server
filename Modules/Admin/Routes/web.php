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

Route::prefix('admin')->group(function () {

    /**
     * authentication
     */
    Route::group(['namespace' => 'Auth'], function () {
        Route::get('/', 'LoginController@getLogin')->name('admin.home');
        Route::get('login', 'LoginController@getLogin')->name('admin.login');
        Route::post('login', 'LoginController@postLogin')->name('admin.login.post');
        Route::get('logout', 'LoginController@logout')->name('admin.logout');
    });

    /**
     * dashboard
     */
    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', 'DashboardController@index')->name('admin.dashboard');
        Route::post('/dashboard/data', 'DashboardController@data')->name('dashboard.data');

        Route::resource('/admin-user', 'AdminController');
        Route::post('/admin-user-list', 'AdminController@list')->name('admin-user.list');
        Route::get('/admin-profile/{id}', 'AdminController@profile')->name('admin-user.profile');
        Route::put('/admin-profile/{id}', 'AdminController@updateProfile')->name('admin-user.update.profile');
        Route::post('/admin-user/{id}/recover', 'AdminController@recover')->name('admin-user.recover');

        Route::get('/parent', 'AdminController@parentListIndex')->name('parent-list.index');
        Route::post('/parent-list', 'AdminController@parentList')->name('parent-list.list');
    });
});
