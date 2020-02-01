<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

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
        Relation::morphMap([
            'user'   => 'App\User',
            'server' => 'App\Models\Server',
            'group'  => 'App\Models\Group',
        ]);

        Passport::routes(function ($router) {
            $router->forAccessTokens();
        });
    }
}
