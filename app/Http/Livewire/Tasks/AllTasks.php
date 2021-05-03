<?php

namespace App\Http\Livewire\Tasks;

use Livewire\Component;
use Livewire\WithPagination;

class AllTasks extends Component
{
    public $listeners = [
        'taskChecked' => 'render',
        'taskAdded' => 'render',
        'taskDeleted' => 'render',
    ];
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $readyToLoad = false;

    public function loadAllTasks()
    {
        $this->readyToLoad = true;
    }

    public function getAllTasks()
    {
        return auth()->user()->tasks()
            ->where('done', false)
            ->latest()
            ->paginate(10);
    }

    public function render()
    {
        return view('livewire.tasks.all-tasks', [
            'tasks' => $this->readyToLoad ? $this->getAllTasks() : [],
        ]);
    }
}
