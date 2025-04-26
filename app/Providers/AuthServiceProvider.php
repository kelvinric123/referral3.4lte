<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Define role-based Gates for menu visibility
        Gate::define('super-admin', function ($user) {
            return $user->hasRole('super-admin');
        });

        Gate::define('hospital-admin', function ($user) {
            return $user->hasRole('hospital-admin');
        });

        Gate::define('consultant', function ($user) {
            return $user->hasRole('consultant');
        });

        Gate::define('gp-doctor', function ($user) {
            return $user->hasRole('gp-doctor');
        });

        Gate::define('booking-agent', function ($user) {
            return $user->hasRole('booking-agent');
        });
    }
}
