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

Route::post('/sendmessage', 'SendMessageController@index');

// Route::post('/sendmessage', array('before' => 'csrf', function () {
// 				  $rules = array(
// 				    'UserPhone' => array('required', 'text'),
// 				    'UserName' => array('required', 'text')
// 				  );
// 				}
// ));

Route::get('showplan/{id}', 'HomeController@showPlan');

Auth::routes();

Route::get('/adminattackplans', 'AdminPanelController@index');
