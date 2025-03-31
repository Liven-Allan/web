<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Define the "edit-project" gate
        Gate::define('edit-project', function ($user, $project) {
            return $user->role === 'patron' && $user->id === $project->patron_id;
        });
    
        // Define the "delete-project" gate
        Gate::define('delete-project', function ($user, $project) {
            return $user->role === 'patron' && $user->id === $project->patron_id;
        });
    }
}
