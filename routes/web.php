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

Route::get('/', function () {
    return view('welcome');
});

Route::get('wechat', ['uses' => 'WechatController@index', 'as' => 'wechat.index']);
Route::get('redirect', ['uses' => 'WechatController@redirect', 'as' => 'wechat.redirect']);

Route::post('js-config', ['uses' => 'WechatController@jsConfig', 'as' => 'wechat.js_config']);
Route::post('access_token', ['uses' => 'WechatController@accessToken', 'as' => 'wechat.access_token']);

Route::get('wx-auth', ['uses' => 'WechatController@wxAuth', 'as' => 'wechat.wx_auth', 'middleware' => ['wechat.oauth:snsapi_userinfo']]);
Route::get('wx-base-auth', ['uses' => 'WechatController@wxBaseAuth', 'as' => 'wechat.wx_base_auth', 'middleware' => ['wechat.oauth:snsapi_base']]);

Route::any('qrcode', ['uses' => 'WechatController@qrcode']);

Route::get('mp', ['uses' => 'MpController@index', 'as' => 'mp.index']);
Route::get('image', ['uses' => 'MpController@image', 'as' => 'mp.image']);
