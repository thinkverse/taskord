<?php

namespace App\Http\Livewire\Admin\Features;

use App\Models\Feature;
use Livewire\Component;

class Features extends Component
{
    public $readyToLoad = false;

    public function loadFeatures()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        return view('livewire.admin.features.features', [
            'features' => $this->readyToLoad ? Feature::latest()->get() : [],
        ]);
    }
}
