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
    Route::get('ajax', ['uses'=>'IndexController@ajax', 'as'=>'admin.index.ajax']);

    Route::post('formUpload', ['uses'=>'IndexController@formUpload', 'as'=>'admin.index.form_upload']);

    Route::resource('permission', 'PermissionsController', ['except'=>'show'])->names('admin.permission');

    Route::resource('role', 'RolesController', ['except'=>'show'])->names('admin.role');

    Route::get('user/check', ['uses'=>'UsersController@checkAdmin', 'as'=>'admin.user.check']);
    Route::resource('user', 'UsersController', ['except'=>'show'])->names('admin.user');

    Route::get('keywords_type/check', ['uses'=>'KeywordsTypeController@checkType', 'as'=>'admin.keywords_type.check']);
    Route::resource('keywords_type', 'KeywordsTypeController', ['except'=>'show'])->names('admin.keywords_type');

    Route::get('keywords/check', ['uses'=>'KeywordsController@checkType', 'as'=>'admin.keywords.check']);
    Route::resource('keywords', 'KeywordsController', ['except'=>'show'])->names('admin.keywords');

});
Route::get('login', ['uses'=>'AuthController@showLoginForm', 'as'=>'admin.login', 'middleware'=>['guest:admin']]);
Route::post('login', ['uses'=>'AuthController@login', 'as'=>'admin.doLogin']);

Route::post('profile', ['uses'=>'AuthController@profile', 'as'=>'admin.profile', 'middleware'=>['auth:admin']]);
Route::get('logout', ['uses'=>'AuthController@logout', 'as'=>'admin.logout', 'middleware'=>['auth:admin']]);
