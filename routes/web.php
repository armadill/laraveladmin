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

Route::get('masuklah','PaymentController@indexbayar');
Route::get('coba','HomeController@cronsewa');
Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register'=>true, 'reset'=>true]);
Auth::routes();

Route::get('test','PaymentController@getpayment');


Route::get('snap/{random}/{id}','PaymentController@getSnapToken');

Route::get('bayar/{nope}/{random}/{id}','PaymentController@getpay');



Route::post('notifikasi','PaymentController@notif');


Route::get('kirim','PaymentController@indexbayar');


Route::get('/home', 'HomeController@index')->name('home');
Route::get('homeload','HomeController@loadtabelsewa')->name('ajax.load.tabelsewa');
Route::post('postsewa','HomeController@postsewwa');
Route::post('hapusdatadomain','HomeController@hapusdatadomain');
Route::post('updatesewa','HomeController@updatesewa');
Route::post('postkirimtagihan','HomeController@postkirimtagihan');

//configapp
Route::post('postapp','HomeController@postapp');

