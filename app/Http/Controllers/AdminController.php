<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;

class AdminController extends Controller
{
    public function users()
    {
        $users = User::latest('last_active')->paginate(50);
        $count = User::all()->count('id');

        return view('admin.users', [
            'users' => $users,
            'count' => $count,
        ]);
    }

    public function tasks()
    {
        $tasks = Task::latest()->paginate(50);
        $count = Task::all()->count('id');

        return view('admin.tasks', [
            'tasks' => $tasks,
            'count' => $count,
        ]);
    }

    public static function toggle()
    {
        $user = Auth::user();
        if ($user->staffShip) {
            $user->staffShip = false;
            $user->save();

            return 'disabled';
        } else {
            $user->staffShip = true;
            $user->save();

            return 'enabled';
        }
    }

    public static function clean()
    {
        Artisan::call('app:clean');

        return redirect('/');
    }
}
