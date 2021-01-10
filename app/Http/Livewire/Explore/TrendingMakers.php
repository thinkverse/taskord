<?php

namespace App\Http\Livewire\Explore;

use Livewire\Component;
use App\Models\User;

class TrendingMakers extends Component
{
    public $readyToLoad = false;

    public function loadTrendingMakers()
    {
        $this->readyToLoad = true;
    }
    
    public function render()
    {
        $users = User::where([
                ['isFlagged', false],
                ['isStaff', false],
            ])
            ->latest('last_active')
            ->take(5)
            ->get()
            ->sortByDesc('reputations')
            ->sortByDesc('streaks');
            
        return view('livewire.explore.trending-makers', [
            'users' => $this->readyToLoad ? $users : []
        ]);
    }
}
