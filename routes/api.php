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

Route::get('city', ['uses'=>'Api\RegionsController@index', 'as' => 'api.city.index']);
Route::post('upload', ['uses'=>'Api\WebController@upload', 'as' => 'api.web.upload']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
