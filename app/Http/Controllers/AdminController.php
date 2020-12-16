<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class AdminController extends Controller
{
    public function users()
    {
        $users = User::latest('last_active')->paginate(50);
        $count = User::all()->count('id');
        activity()
            ->withProperties(['type' => 'Admin'])
            ->log('Opened /admin/users');

        return view('admin.users', [
            'users' => $users,
            'count' => $count,
        ]);
    }

    public function tasks()
    {
        $tasks = Task::latest()->paginate(50);
        $count = Task::all()->count('id');
        activity()
            ->withProperties(['type' => 'Admin'])
            ->log('Opened /admin/tasks');

        return view('admin.tasks', [
            'tasks' => $tasks,
            'count' => $count,
        ]);
    }

    public function activities()
    {
        $activities = Activity::latest()->paginate('50');
        $count = Activity::all()->count('id');
        activity()
            ->withProperties(['type' => 'Admin'])
            ->log('Opened /admin/activities');

        return view('admin.activities', [
            'activities' => $activities,
            'count' => $count,
        ]);
    }

    public static function toggle()
    {
        $user = Auth::user();
        if ($user->staffShip) {
            $user->staffShip = false;
            $user->save();
            activity()
                ->withProperties(['type' => 'Admin'])
                ->log('Disabled StaffShip');

            return 'disabled';
        } else {
            $user->staffShip = true;
            $user->save();
            activity()
                ->withProperties(['type' => 'Admin'])
                ->log('Enabled StaffShip');

            return 'enabled';
        }
    }

    public static function clean()
    {
        Artisan::call('app:clean');
        activity()
            ->withProperties(['type' => 'Admin'])
            ->log('Cleaned the Taskord Application');

        return redirect()->route('home');
    }
}
