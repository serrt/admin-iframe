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

Route::get('city', ['uses'=>'Api\WebController@city', 'as' => 'api.web.city']);
Route::post('upload', ['uses'=>'Api\WebController@upload', 'as' => 'api.web.upload']);
Route::get('permission', ['uses'=>'Api\WebController@permission', 'as' => 'api.web.permission']);
