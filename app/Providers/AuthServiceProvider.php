<?php

namespace App\Providers;

use App\Models\Comment;
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

        Gate::define('check.task', function (User $user, Task $task) {
            if ($user->spammy) {
                return false;
            }

            if ($user->id === $task->user->id) {
                return true;
            }
        });

        Gate::define('praise.task', function (User $user, Task $task) {
            if (
                $user->spammy or
                ! $user->hasVerifiedEmail() or
                $user->id === $task->user->id

            ) {
                return false;
            }

            return true;
        });

        Gate::define('delete.task', function (User $user, Task $task) {
            if ($user->spammy) {
                return false;
            }

            if ($user->staff_mode or $user->id === $task->user->id) {
                return true;
            }
        });

        Gate::define('delete.comment', function (User $user, Comment $comment) {
            if ($user->spammy) {
                return false;
            }

            if ($user->staff_mode or $user->id === $comment->user->id) {
                return true;
            }
        });
    }
}
