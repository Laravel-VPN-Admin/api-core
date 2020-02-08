<?php

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'Admin\IndexController@index')->name('home');
});

// Route everything else to Vue
Route::get('{any?}', function () {
    return view('index');
})->where('any', '.*');
