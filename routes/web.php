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

Route::get('/', 'HomeController@index');

Route::get('/paypal', 'PayPalController@index');
Route::get('/paypal/valid', 'PayPalController@validPayment');
Route::get('/paypal/error', 'PayPalController@errorPayment');
Route::get('/paypal/cancel', 'PayPalController@cancelPayment');

Route::post('/stripe', 'StripeController@valid');
Route::get('/stripe', 'StripeController@index');

Route::get('showplan/{id}', 'HomeController@showPlan');

Route::post('/sendmessage', 'SendMessageController@index');
Route::get('/sendmessage', 'SendMessageController@send');
Route::post('/showplan/sendmessage', 'SendMessageController@index');

Auth::routes();

Route::get('/adminattackplans', 'AdminPanelController@index');
