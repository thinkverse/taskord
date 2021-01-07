<?php

namespace App\Http\Livewire\User\Settings;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Password extends Component
{
    public User $user;
    public $currentPassword;
    public $newPassword;
    public $confirmPassword;

    public function mount($user)
    {
        $this->user = $user;
    }

    public function updated($field)
    {
        if (Auth::check()) {
            $this->validateOnly($field, [
                'currentPassword' => 'required',
                'newPassword' => 'required|min:8|pwned',
                'confirmPassword' => 'required|same:newPassword',
            ],
            [
                'newPassword.pwned' => 'This password has been pwned before',
            ]);
        }
    }

    public function updatePassword()
    {
        if (Auth::check()) {
            if (auth()->user()->id === $this->user->id) {
                $this->validate([
                    'currentPassword' => 'required',
                    'newPassword' => 'required|min:8|pwned',
                    'confirmPassword' => 'required|same:newPassword',
                ],
                [
                    'newPassword.pwned' => 'This password has been pwned before',
                ]);

                if (! Hash::check($this->currentPassword, auth()->user()->password)) {
                    return $this->alert('error', 'Current password does not match!');
                }

                auth()->user()->password = Hash::make($this->newPassword);
                auth()->user()->save();
                loggy(request()->ip(), 'User', auth()->user(), 'Changed account password');

                return $this->alert('success', 'Your password has been changed!');
            } else {
                return $this->alert('error', 'Forbidden!');
            }
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }
}
