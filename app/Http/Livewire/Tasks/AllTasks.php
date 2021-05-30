<?php

namespace App\Http\Livewire\Tasks;

use Livewire\Component;
use Livewire\WithPagination;

class AllTasks extends Component
{
    public $listeners = [
        'refreshTasks' => 'render',
    ];
    use WithPagination;

    public $readyToLoad = false;
    protected $paginationTheme = 'bootstrap';

    public function loadAllTasks()
    {
        $this->readyToLoad = true;
    }

    public function getAllTasks()
    {
        return auth()->user()->tasks()
            ->whereDone(false)
            ->latest()
            ->paginate(30);
    }

    public function render()
    {
        return view('livewire.tasks.all-tasks', [
            'tasks' => $this->readyToLoad ? $this->getAllTasks() : [],
        ]);
    }
}
