<?php

namespace App\Http\Livewire\Explore;

use Livewire\Component;

class TrendingMakers extends Component
{
    public $readyToLoad = false;

    public function loadTrendingMakers()
    {
        $this->readyToLoad = true;
    }
    
    public function render()
    {
        return view('livewire.explore.trending-makers');
    }
}
