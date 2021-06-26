<?php

namespace App\Http\Livewire\Staff\Features;

use App\Models\Feature;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Contracts\View\View;

class Features extends Component
{
    use WithPagination;

    public $readyToLoad = false;
    protected $paginationTheme = 'bootstrap';

    public function loadFeatures()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        return view('livewire.staff.features.features', [
            'features' => $this->readyToLoad ? Feature::latest()->paginate(10) : [],
        ]);
    }
}
