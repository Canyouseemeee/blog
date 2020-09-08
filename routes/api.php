<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/login','AuthController@login');
Route::group(['middleware'=>'auth.jwt'],function(){
    Route::post('/logout','AuthController@logout');
});

Route::get('/issues-closed','Admin\ApiController@Closed');
Route::get('/issues-new','Admin\ApiController@New');
Route::get('/issues-defer','Admin\ApiController@Defer');
Route::get('/issues-getMacAddress','Admin\ApiController@getMacAddress');
Route::post('/issues-postlogin', 'Admin\ApiController@postlogin');
Route::post('/issues-delete', 'Admin\ApiController@delete');

//
Route::post('/issues-postmacAddress', 'Admin\ApiController@postMacAddress');

