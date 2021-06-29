<?php

namespace App\Http\Livewire\Explore;

use Livewire\Component;
use App\Models\User;
use Illuminate\View\View;

class FeaturedMakers extends Component
{
    public $readyToLoad = false;

    public function loadFeaturedMakers()
    {
        $this->readyToLoad = true;
    }

    public function getFeaturedMakers()
    {
        return User::with(['reputations'])
            ->where([
                ['spammy', false],
                ['is_private', false],
                ['is_staff', false],
            ])
            ->where('featured_at', '<>', null)
            ->latest('featured_at')
            ->take(10)
            ->get();
    }

    public function render(): View
    {
        return view('livewire.explore.featured-makers', [
            'users' => $this->readyToLoad ? $this->getFeaturedMakers() : [],
        ]);
    }
}
