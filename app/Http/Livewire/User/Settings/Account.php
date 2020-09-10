<?php

namespace App\Http\Livewire\User\Settings;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Account extends Component
{
    public $user;
    public $username;
    public $email;

    public function mount($user)
    {
        $this->user = $user;
        $this->username = $user->username;
        $this->email = $user->email;
    }

    public function enrollBeta()
    {
        if (Auth::check()) {
            if (Auth::id() === $this->user->id) {
                $this->user->isBeta = ! $this->user->isBeta;
                $this->user->save();
                if ($this->user->isBeta) {
                    session()->flash('isBeta', 'Your are now beta member!');
                } else {
                    session()->flash('isBeta', 'Your are no longer a beta member!');
                }
            } else {
                return session()->flash('error', 'Forbidden!');
            }
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function enrollPrivate()
    {
        if (Auth::check()) {
            if (! $this->user->isPatron) {
                return session()->flash('error', 'Forbidden!');
            }

            if (Auth::check() && Auth::id() === $this->user->id) {
                $this->user->isPrivate = ! $this->user->isPrivate;
                $this->user->save();
                if ($this->user->isPrivate) {
                    return session()->flash('isPrivate', 'All your tasks are now private');
                } else {
                    return session()->flash('isPrivate', 'All your tasks are now public');
                }
            } else {
                return session()->flash('error', 'Forbidden!');
            }
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function updated($field)
    {
        if (Auth::check()) {
            $this->validateOnly($field, [
                'username' => 'required|min:2|max:20|alpha_dash|unique:users,username,'.$this->user->id,
                'email' => 'required|email|max:255|unique:users,email,'.$this->user->id,
            ]);
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function updateAccount()
    {
        if (Auth::check()) {
            $this->validate([
                'username' => 'required|min:2|max:20|alpha_dash|unique:users,username,'.$this->user->id,
                'email' => 'required|email:rfc,dns|max:255|unique:users,email,'.$this->user->id,
            ]);

            if ($this->email !== $this->user->email) {
                $this->user->email_verified_at = null;
            }

            if (Auth::check() && Auth::id() === $this->user->id) {
                $this->user->username = $this->username;
                $this->user->email = $this->email;
                $this->user->save();
                $this->user->sendEmailVerificationNotification();

                return session()->flash('success', 'Your account has been updated!');
            }
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function render()
    {
        return view('livewire.user.settings.account');
    }
}
