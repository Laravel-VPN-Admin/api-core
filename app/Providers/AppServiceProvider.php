<?php

namespace App\Providers;

use App\Observers\UserObserver;
use App\User;
use Illuminate\Database\Eloquent\Relations\Relation;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);

        Relation::morphMap([
            'user'   => 'App\User',
            'server' => 'App\Models\Server',
            'group'  => 'App\Models\Group',
        ]);
    }
}
