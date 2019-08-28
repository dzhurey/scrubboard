<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

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

        Gate::define('superadmin-only', function ($user) {
            return $user->isSuperAdmin();
        });

        Gate::define('courier-only', function ($user) {
            return $user->role == 'courier';
        });

        Gate::define('sales', function ($user) {
            return $user->role == 'sales';
        });

        Gate::define('finance', function ($user) {
            return $user->role == 'finance';
        });

        Gate::define('operation', function ($user) {
            return $user->role == 'operation';
        });

        Gate::define('courier', function ($user) {
            return $user->role == 'courier';
        });

        Gate::define('workshop', function ($user) {
            return $user->role == 'workshop';
        });

        Gate::define('superadmin', function ($user) {
            return $user->role == 'superadmin';
        });
    }
}
