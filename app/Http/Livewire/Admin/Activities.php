<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Activitylog\Models\Activity;

class Activities extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $readyToLoad = false;

    public function loadActivities()
    {
        $this->readyToLoad = true;
    }

    public function getActivities()
    {
        return Activity::latest()->paginate('50');
    }

    public function render()
    {
        return view('livewire.admin.activities', [
            'activities' => $this->readyToLoad ? $this->getActivities() : [],
            'count' => number_format(Activity::count('id')),
        ]);
    }
}
