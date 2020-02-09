<?php

Route::post('/login', 'AuthorizationController@login')->name('login');
Route::post('/refresh', 'AuthorizationController@refresh')->name('refresh')->middleware('auth:api');
Route::get('/me', 'AuthorizationController@me')->name('me')->middleware('auth:api');
