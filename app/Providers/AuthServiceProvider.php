<?php

namespace App\Providers;

use App\Models\Task;
use App\Models\User;
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

        Gate::define('staff_mode', function (User $user) {
            return $user->is_staff and $user->staff_mode;
        });

        Gate::define('is_staff', function (User $user) {
            return $user->is_staff;
        });

        Gate::define('user.follow', function (User $sourceUser, User $targetUser) {
            return $this->isCurrentUserGood($sourceUser, $targetUser);
        });

        Gate::define('task.check', function (User $user, Task $task) {
            if ($user->spammy) {
                return false;
            }

            if ($user->id === $task->user->id) {
                return true;
            }

            return false;
        });

        Gate::define('create', function (User $user) {
            return $this->isUserVerified($user);
        });

        Gate::define('praise', function (User $user, $entity) {
            return $this->isCurrentUserGood($user, $entity->user);
        });

        Gate::define('act', function (User $user, $entity) {
            if ($user->spammy) {
                return false;
            }

            if ($user->staff_mode or $user->id === $entity->user->id) {
                return true;
            }
        });
    }

    public function isCurrentUserGood(User $currentUser, User $entityUser)
    {
        if (
            $currentUser->spammy or
            ! $currentUser->hasVerifiedEmail() or
            $currentUser->id === $entityUser->id
        ) {
            return false;
        } else {
            return true;
        }
    }

    public function isUserVerified(User $user)
    {
        if (
            $user->spammy or
            ! $user->hasVerifiedEmail()
        ) {
            return false;
        } else {
            return true;
        }
    }
}
