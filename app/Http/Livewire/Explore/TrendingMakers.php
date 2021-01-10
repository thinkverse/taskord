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
        $users = User::select('id', 'username', 'firstname', 'lastname', 'avatar', 'bio', 'isVerified', 'created_at')
            ->where([
                ['isFlagged', false],
                ['isStaff', false],
            ])
            ->orderBy('created_at', 'DESC')
            ->take(5)
            ->get();
            
        return view('livewire.explore.trending-makers', [
            'users' => $this->readyToLoad ? $users : []
        ]);
    }
}
