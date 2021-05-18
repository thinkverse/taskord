<?php

namespace App\Http\Livewire\Home;

use Livewire\Component;

class OnlyFollowing extends Component
{
    public function onlyFollowingsTasks()
    {
        if (auth()->check()) {
            auth()->user()->onlyFollowingsTasks = ! auth()->user()->onlyFollowingsTasks;
            auth()->user()->save();
            $this->emit('onlyFollowings');
            loggy(request(), 'User', auth()->user(), 'Toggled only followings tasks');

            if (auth()->user()->onlyFollowingsTasks) {
                return $this->alert('success', 'Only following users tasks will be visible!');
            } else {
                return $this->alert('success', 'All users tasks will be visible!');
            }
        } else {
            return $this->dispatchBrowserEvent('toast', [
                'type' => 'error',
                'body' => 'Forbidden!'
            ]);
        }
    }
}
