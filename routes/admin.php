<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
*/

Route::group([], function () {
    Route::get('/', ['uses'=>'IndexController@index', 'as'=>'admin']);

    Route::get('home', ['uses'=>'IndexController@home', 'as'=>'admin.index.home']);
    Route::get('table', ['uses'=>'IndexController@table', 'as'=>'admin.index.table']);
    Route::get('form', ['uses'=>'IndexController@form', 'as'=>'admin.index.form']);
});
Route::get('login', ['uses'=>'IndexController@login', 'as'=>'admin.login']);
