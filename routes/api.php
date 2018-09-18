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

Route::group(['prefix' => 'web'], function () {
    Route::get('city', ['uses'=>'Api\WebController@city', 'as' => 'api.web.city']);
    Route::post('upload', ['uses'=>'Api\WebController@upload', 'as' => 'api.web.upload']);
    Route::get('permission', ['uses'=>'Api\WebController@permission', 'as' => 'api.web.permission']);
    Route::get('role', ['uses'=>'Api\WebController@role', 'as' => 'api.web.role']);
    Route::get('keywords_type', ['uses'=>'Api\WebController@keywordsType', 'as' => 'api.web.keywords_type']);
    Route::get('keywords', ['uses'=>'Api\WebController@keywords', 'as' => 'api.web.keywords']);
});

Route::group(['prefix' => 'wechat', 'middleware' => 'auth:wechat', 'namespace' => 'Api'], function () {
    Route::apiResource('message', 'WechatUserMsgController')->names('api.wechat_user_msg');
});

Route::group(['middleware' => ['auth:wechat']], function () {
    Route::get('auth', ['uses'=>'WechatController@auth']);

    Route::get('message', ['uses' => 'Api\WechatUserMsgController@index'])->name('api.message.index');
    Route::post('message', ['uses' => 'Api\WechatUserMsgController@store'])->name('api.message.store');
});

Route::group(['prefix' => 'face', 'namespace' => 'Api'], function () {
    Route::post('detect', ['uses' => 'FaceController@detect'])->name('api.face.detect');
    Route::post('merge', ['uses' => 'FaceController@merge'])->name('api.face.merge');
    Route::post('multiple_merge', ['uses' => 'FaceController@multipleMerge'])->name('api.face.multiple_merge');
});
