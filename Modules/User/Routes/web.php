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

/**
 * authentication
 */
Route::group(['namespace' => 'Auth'], function () {
    /**
     * registeration
     */
    Route::get('register/step/one', 'RegisterController@getStepOne')->name('user.register.step.one.get')->middleware('guest');
    Route::post('register/step/one', 'RegisterController@postStepOne')->name('user.register.step.one.post');

    Route::get('register/step/two', 'RegisterController@getStepTwo')->name('user.register.step.two.get')->middleware('guest');
    Route::post('register/step/two', 'RegisterController@postStepTwo')->name('user.register.step.two.post');

    Route::get('register/step/three', 'RegisterController@getStepThree')->name('user.register.step.three.get')->middleware('guest');
    Route::post('register/step/three', 'RegisterController@postStepThree')->name('user.register.step.three.post');

    Route::get('register/step/four', 'RegisterController@getStepFour')->name('user.register.step.four.get')->middleware('guest');
    Route::post('register/step/four', 'RegisterController@postStepFour')->name('user.register.step.four.post');

    Route::get('register/step/five', 'RegisterController@getStepFive')->name('user.register.step.five.get')->middleware('guest');
    Route::post('register/step/five', 'RegisterController@postStepFive')->name('user.register.step.five.post');

    Route::get('register/step/six', 'RegisterController@getStepSix')->name('user.register.step.six.get')->middleware('guest');
    Route::post('register/step/six', 'RegisterController@postStepSix')->name('user.register.step.six.post');

    Route::get('register/step/six/paymentSuccess', 'RegisterController@getPaymentSuccessUrl')->name('user.register.step.six.payment.success');
    Route::get('register/step/six/paymentFailure', 'RegisterController@getPaymentFailureUrl')->name('user.register.step.six.payment.fail');

    Route::get('login', 'LoginController@getLogin')->name('user.login');
    Route::post('login', 'LoginController@postLogin')->name('user.login.post');

    Route::get('logout', 'LoginController@logout')->name('user.logout');

    Route::get('register', 'RegisterController@getRegister')->name('user.register');
    Route::post('register', 'RegisterController@postRegister')->name('user.register.post');

    // Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm');
    // Route::post('password/reset', 'ResetPasswordController@reset');
    // Route::post('password/forgot', 'ForgotPasswordController@sendResetLinkEmail');
    // Route::get('password/reset/{token}/{email}', 'ResetPasswordController@showResetForm');
});

/**
 * dashboard
 */
Route::middleware(['auth'])->get('dashboard', 'DashboardController@index')->name('user.dashboard');

Route::get('language/{locale}', 'UserController@changeLanguage')->name('language.change');
Route::middleware(['auth'])->prefix('admin')->group(function() {

    Route::get('/user-activity', 'UserController@userActivityIndex')->name('user.activity');
    Route::post('/user-activity-list', 'UserController@list')->name('user.activity.list');

    Route::get('/audit-log', 'UserController@auditActivityIndex')->name('audit-log.activity');
    Route::get('/audit-log/{id}', 'UserController@auditActivityShow')->name('audit-log.activity.get');
    Route::post('/audit-log-list', 'UserController@auditList')->name('audit-log.activity.list');
		Route::get('/empty-wish-list', 'ApiController@emptyWishlist')->name('empty-Wishlist');

});
