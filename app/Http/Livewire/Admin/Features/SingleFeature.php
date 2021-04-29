<?php

namespace App\Http\Livewire\Admin\Features;

use App\Models\Feature;
use Livewire\Component;

class SingleFeature extends Component
{
    public Feature $feature;
    public $status;
    public $betaStatus;

    public function mount($feature)
    {
        $this->feature = $feature;
        $this->status = $feature->enabled;
        $this->betaStatus = $feature->beta;
    }

    public function betaToggle()
    {
        $this->feature->beta = $this->betaStatus;
        $this->feature->save();
    }

    public function toggleFeature()
    {
        $this->feature->enabled = $this->status;
        $this->feature->save();
    }

    public function render()
    {
        return view('livewire.admin.features.single-feature');
    }
}
