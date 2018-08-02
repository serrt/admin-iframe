<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
*/

Route::group([], function () {
    Route::get('/', ['uses'=>'IndexController@index', 'as'=>'admin']);

    Route::get('home', ['uses'=>'IndexController@home', 'as'=>'admin.home']);
});
Route::get('login', ['uses'=>'IndexController@login', 'as'=>'admin.login']);
