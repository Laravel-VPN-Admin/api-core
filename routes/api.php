<?php

Route::post('/login', 'AuthorizationController@login')->name('login');
Route::post('/refresh', 'AuthorizationController@refresh')->name('refresh')->middleware('api.authorized');
