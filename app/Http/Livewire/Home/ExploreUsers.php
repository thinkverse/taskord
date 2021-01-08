<?php

namespace App\Http\Livewire\Home;

use Livewire\Component;

class ExploreUsers extends Component
{
    public $readyToLoad = false;

    public function loadExploreUsers()
    {
        $this->readyToLoad = true;
    }
    
    public function render()
    {
        return view('livewire.home.explore-users');
    }
}
