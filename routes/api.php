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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/getLatestArticles', 'API\ArticleController@get_latest_articles');
Route::get('/getArticles', 'API\ArticleController@get_articles');
Route::post('/addContact', 'API\ContactController@add_contact');
Route::get('/getArticle/{url}', 'API\ArticleController@get_article_by_url')->where('{url}', '([A-z0-9-+_.\/]+)?');
Route::get('/checkArticleForPremium/{url}', 'API\ArticleController@check_article_for_premium')->where('{url}', '([A-z0-9-+_.\/]+)?');
Route::post('/signup', 'API\AuthController@signup');
Route::post('/signin', 'API\AuthController@signin');
Route::post('/forgotPassword', 'API\AuthController@forgot_password');
Route::get('/getCustomer/{token}', 'API\AuthController@get_customer')->where('{token}', '([A-z0-9]+)?');
Route::post('/resetPassword', 'API\AuthController@reset_password');

Route::middleware('auth:api')->group(function() {
    Route::post('/updateProfile', 'API\AuthController@update_profile');
    Route::post('/logout', 'API\AuthController@logout');
    Route::post('/payment/create', 'API\PaymentController@create_payment');
    Route::post('/payment/execute', 'API\PaymentController@execute_payment');
    Route::get('/getCustomerData', 'API\AuthController@get_customer_data');
    Route::post('/addComment', 'API\ArticleController@add_comment');
    Route::post('/updateComment', 'API\ArticleController@update_comment');
    Route::post('/deleteComment', 'API\ArticleController@delete_comment');
});
