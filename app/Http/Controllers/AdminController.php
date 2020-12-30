<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class AdminController extends Controller
{
    public function users()
    {
        return view('admin.users');
    }

    public function tasks()
    {
        return view('admin.tasks');
    }

    public function activities()
    {
        $activities = Activity::latest()->paginate('50');
        $count = Activity::all()->count('id');

        return view('admin.activities', [
            'activities' => $activities,
            'count' => number_format($count),
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
                ->log('Disabled Staff Ship');

            return response()->json([
                'status' => 'disabled',
            ]);
        } else {
            $user->staffShip = true;
            $user->save();
            activity()
                ->withProperties(['type' => 'Admin'])
                ->log('Enabled Staff Ship');

            return response()->json([
                'status' => 'enabled',
            ]);
        }
    }
}
