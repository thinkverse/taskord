<?php

namespace App\Http\Livewire\Notification;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Icon extends Component
{
    public function render()
    {
        if (Auth::check()) {
            Auth::user()->lastIP = request()->ip();
            Auth::user()->last_active = Carbon::now();
            Auth::user()->save();
        }

        return view('livewire.notification.icon');
    }
}
