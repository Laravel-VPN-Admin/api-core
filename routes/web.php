<?php


Route::get('/login', function () {
  return \Inertia\Inertia::render('Login');
})->name('login');

Route::group(['middleware' => ['auth']], function () {
  Route::get('/', function () {
    return \Inertia\Inertia::render('Pages/Dashboard');
  })->name('dashboard');

  Route::get('/servers', function () {
    return \Inertia\Inertia::render('Pages/Servers');
  });

  Route::get('/servers/create', function () {
    return \Inertia\Inertia::render('Pages/ServerCreate');
  });

  Route::get('/servers/edit/{id}', function ($id) {
    return \Inertia\Inertia::render('Pages/ServerEdit', [
        'id' => (int)$id
    ]);
  });

  Route::get('/users', function () {
    return \Inertia\Inertia::render('Pages/Users');
  });

  Route::get('/users/create', function () {
    return \Inertia\Inertia::render('Pages/UserCreate');
  });

  Route::get('/users/edit/{id}', function ($id) {
    return \Inertia\Inertia::render('Pages/UserEdit', [
        'id' => (int)$id
    ]);
  });

  Route::get('/groups', function () {
    return \Inertia\Inertia::render('Pages/Groups');
  });

  Route::get('/groups/create', function () {
    return \Inertia\Inertia::render('Pages/GroupCreate');
  });

  Route::get('/groups/edit/{id}', function ($id) {
    return \Inertia\Inertia::render('Pages/GroupEdit', [
        'id' => (int)$id
    ]);
  });

  Route::get('/logs', function () {
    return \Inertia\Inertia::render('Pages/Logs');
  });

  Route::get('/logs/show/{id}', function ($id) {
    return \Inertia\Inertia::render('Pages/Log', [
        'id' => (int)$id
    ]);
  });
});

