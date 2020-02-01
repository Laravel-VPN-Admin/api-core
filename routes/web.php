<?php

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'Admin\IndexController@index')->name('home');
});
