<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function users()
    {
        return view('admin.users');
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
}
