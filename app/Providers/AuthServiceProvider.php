<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Event;
use App\Models\Guest;
use App\Models\Organizer;
use App\Models\User;
use App\Policies\EventPolicy;
use App\Policies\GuestPolicy;
use App\Policies\OrganizerPolicy;
use App\Policies\UserPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Event::class => EventPolicy::class,
        Guest::class => GuestPolicy::class,
        Organizer::class => OrganizerPolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Boot the application services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Define global gates for actions not tied to a specific resource
        Gate::define('manage-users', function (User $user) {
            return $user->isAdmin();
        });

        Gate::define('view-reports', function (User $user) {
            return $user->isAdmin() || $user->isOrganizer();
        });

        Gate::define('export-reports', function (User $user) {
            return $user->isAdmin() || $user->isOrganizer();
        });

        Gate::define('access-admin', function (User $user) {
            return $user->isAdmin();
        });
    }

    /**
     * Register the application's policies.
     */
    public function registerPolicies(): void
    {
        foreach ($this->policies as $model => $policy) {
            Gate::policy($model, $policy);
        }
    }
}
