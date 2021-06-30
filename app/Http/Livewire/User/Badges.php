<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use App\Models\User;
use App\Models\ProfileBadge;
use Illuminate\View\View;

class Badges extends Component
{
    public $readyToLoad = false;
    public User $user;

    public function mount($user)
    {
        $this->user = $user;
    }

    public function loadBadges()
    {
        $this->readyToLoad = true;
    }

    public function getBadges()
    {
        return $this->user
            ->subscriptions(ProfileBadge::class)
            ->get();
    }

    public function render(): View
    {
        return view('livewire.user.badges', [
            'badges' => $this->readyToLoad ? $this->getBadges() : [],
        ]);
    }
}
