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

Route::post('daftar', 'api\registercontrol@daftar');
Route::post('login', 'api\registercontrol@postlogin');

Route::post('postdomain', 'Api\registercontrol@postdomain');

Route::post('postappconfig', 'Api\registercontrol@postappconfig');

Route::get('sewa', 'Api\registercontrol@getsewa');

Route::get('ceksewa/{domain}', 'Api\registercontrol@ceksewa');
 
Route::get('ceklock/{key}', 'Api\registercontrol@ceklock');



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


