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

Route::get('/', function () {
    return redirect('/home');
});

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

Route::get('/{url}', 'HomeController@index')->where('{url}', '([A-z0-9\/._+-]+)?');
Route::get('/blog/{url}', 'HomeController@index')->where('{url}', '([A-z0-9\/._+-]+)?');

// Route::middleware('auth:api')->group(function() {
    // Route::post('/payment/pay', 'PaymentController@pay');
// });

// Route::get('/payment-redirect', 'PaymentController@payment_redirect');
// Route::get('/payment-cancel', 'PaymentController@payment_cancel');
