<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
      $this->registerPolicies();
      //Route middleware for admin section
      Gate::define('visit-admin', function ($user){
        return $user->hasAnyRoles(['admin', 'moderator']);
      });


      Gate::define('manage-users', function ($user){
        return $user->hasAnyRoles(['admin', 'moderator']);
      });

      Gate::define('edit-user', function ($user){
        return $user->hasRole('admin');
      });

      Gate::define('delete-user', function ($user){
        return $user->hasRole('admin');
      });
    }
}
