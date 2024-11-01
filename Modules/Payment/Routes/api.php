<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::any('/KnetPaymentSuccess', 'ApiController@KnetPaymentSuccess')->name('KnetPaymentSuccess');
Route::get('/KnetPaymentFailed', 'ApiController@KnetPaymentFailed')->name('KnetPaymentFailed');

Route::post('/CreditCardPaymentInquiry', 'ApiController@CreditCardPaymentInquiry')->name('CreditCardPaymentInquiry');
Route::post('/CreditCardPaymentSuccess', 'ApiController@CreditCardPaymentSuccess')->name('CreditCardPaymentSuccess');
Route::get('/CreditCardPaymentFailed', 'ApiController@CreditCardPaymentFailed')->name('CreditCardPaymentFailed');

// Knet Callback URL
Route::get('/MyFatoorahCallback', 'ApiController@MyFatoorahCallback')->name('MyFatoorahCallback');
// Route::get('/MyFatoorahFailed', 'ApiController@MyFatoorahFailed');
