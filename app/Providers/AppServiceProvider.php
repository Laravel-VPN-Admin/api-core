<?php

namespace App\Providers;

use App\Observers\UserObserver;
use App\User;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
    if ($this->app->isLocal()) {
      $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
      $this->app->register(TelescopeServiceProvider::class);
    }
  }

  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot()
  {

    Schema::defaultStringLength(191);
    User::observe(UserObserver::class);

    Relation::morphMap([
        'user'   => 'App\User',
        'server' => 'App\Models\Server',
        'group'  => 'App\Models\Group',
    ]);
  }
}
