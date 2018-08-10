<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
*/

Route::group(['middleware' => ['auth:admin']], function () {
    Route::get('/', ['uses'=>'IndexController@index', 'as'=>'admin']);

    Route::get('home', ['uses'=>'IndexController@home', 'as'=>'admin.index.home']);
    Route::get('table', ['uses'=>'IndexController@table', 'as'=>'admin.index.table']);
    Route::get('form', ['uses'=>'IndexController@form', 'as'=>'admin.index.form']);
    Route::post('formUpload', ['uses'=>'IndexController@formUpload', 'as'=>'admin.index.form_upload']);
});
Route::get('login', ['uses'=>'AuthController@showLoginForm', 'as'=>'admin.login', 'middleware'=>['guest:admin']]);
Route::post('login', ['uses'=>'AuthController@login', 'as'=>'admin.doLogin']);

Route::post('profile', ['uses'=>'AuthController@profile', 'as'=>'admin.profile', 'middleware'=>['auth:admin']]);
Route::get('logout', ['uses'=>'AuthController@logout', 'as'=>'admin.logout', 'middleware'=>['auth:admin']]);
