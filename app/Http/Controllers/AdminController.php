<?php

namespace App\Http\Controllers;

use Spatie\Activitylog\Models\Activity;

class AdminController extends Controller
{
    public static function toggle()
    {
        if (auth()->user()->staffShip) {
            auth()->user()->staffShip = false;
            auth()->user()->save();
            activity()
                ->withProperties(['type' => 'Admin'])
                ->log('Disabled Staff Ship');

            return response()->json([
                'status' => 'disabled',
            ]);
        } else {
            auth()->user()->staffShip = true;
            auth()->user()->save();
            activity()
                ->withProperties(['type' => 'Admin'])
                ->log('Enabled Staff Ship');

            return response()->json([
                'status' => 'enabled',
            ]);
        }
    }
}
