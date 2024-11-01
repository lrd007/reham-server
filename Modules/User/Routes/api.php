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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/login', 'ApiController@login');
Route::post('/register', 'ApiController@register');
Route::get('/countries', 'ApiController@countries');

Route::get('/forgot_password_page', 'ApiController@forgotPasswordPage')->name('forgot_password_page');
Route::post('/forgot_password_link', 'ApiController@forgot_password_link')->name('forgot_password_link');
Route::get('/forgot_password', 'ApiController@forgot_password_link')->name('forgot_password_link');
Route::post('/reset_password', 'ApiController@reset_password');

// Protected APIs.
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/user_password_reset', 'ApiController@user_password_reset');
    Route::get('/user_details', 'ApiController@user_details_get');
    Route::post('/user_details', 'ApiController@user_details_post');

    // wishlist routes.
    Route::get('/add_to_wishlist', 'ApiController@add_to_wishlist');
    Route::get('/remove_from_wishlist', 'ApiController@remove_from_wishlist');
    Route::get('/get_wishlist', 'ApiController@get_wishlist');


    // cart routes.
    Route::post('/add_to_cart', 'ApiController@add_to_cart');
    Route::get('/remove_from_cart', 'ApiController@remove_from_cart');
    Route::get('/get_cart', 'ApiController@get_cart');

    // my courses.
    Route::get('/my_courses', 'ApiController@my_courses');

    // check isAdmin.
    Route::get('/isAdmin', 'ApiController@isAdmin');

    // Knet Checkout.
    Route::post('/checkout', 'ApiController@checkout');
});
