<?php

// Default page where VueJS app will executed
Route::get('/', 'IndexController@index')->name('index');
Route::get('/new', 'IndexController@new')->name('index.new');

Route::namespace('Admin')->prefix('admin')->name('admin.')->middleware('can:visit-admin')->group(function () {

  Route::get('/', 'DashboardController@index')->name('home');
  Route::resource('users', 'UsersController')->except(['destroy', 'create', 'show', 'store', 'update']);

});


Route::get('locale/{locale}/{id}', function ($locale, $id) {
  Session::put('locale', $locale);
  Session::put('locale_id', $id);
  return redirect()->back();
});
