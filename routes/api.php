<?php
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
    Route::any('file_remove', ['uses' => 'Api\WebController@fileRemove', 'as' => 'api.web.file_remove']);

    Route::any('test', ['uses' => 'Api\WechatPayController@test']);
});

Route::group(['prefix' => 'wechat', 'middleware' => 'auth:wechat', 'namespace' => 'Api'], function () {

    // 留资(重复了, 后面再来删除)
    Route::apiResource('message', 'WechatUserMsgController', ['only' => ['index', 'store']])->names('api.wechat_user_msg');

    // 支付
    Route::post('pay', ['uses' => 'WechatUserController@pay']);
});

// 微信小程序code
Route::post('code', ['uses' => 'WechatController@index']);

Route::group(['middleware' => ['auth:wechat']], function () {
    // 获取当前用户信息
    Route::get('user', ['uses'=>'Api\WechatUserController@info']);
    // 更新用户信息
    Route::post('user', ['uses' => 'Api\WechatUserController@update']);
    // 解密
    Route::post('user/decrypt', ['uses' => 'Api\WechatUserController@decrypt']);

    // 留资
    Route::get('message', ['uses' => 'Api\WechatUserMsgController@index'])->name('api.message.index');
    Route::post('message', ['uses' => 'Api\WechatUserMsgController@store'])->name('api.message.store');
    Route::post('multiple_message', ['uses' => 'Api\WechatUserMsgController@storeMultiple', 'as' => 'api.message.store_multiple']);
});

Route::group(['prefix' => 'face', 'namespace' => 'Api'], function () {
    Route::any('detect', ['uses' => 'FaceController@detect'])->name('api.face.detect');
    Route::any('merge', ['uses' => 'FaceController@merge'])->name('api.face.merge');
    Route::any('multiple_merge', ['uses' => 'FaceController@multipleMerge'])->name('api.face.multiple_merge');
});

Route::any('wechat/notify', ['uses' => 'WechatController@notify', 'as' => 'api.wechat.notify']);

Route::get('msg', ['uses' => 'WechatMsgController@index']);
Route::get('msg/send', ['uses' => 'WechatMsgController@send']);
Route::get('msg/send_article', ['uses' => 'WechatMsgController@sendArticle']);
