<?php

namespace App\Http\Livewire\Staff;

use App\Models\Task;
use Livewire\Component;
use Livewire\WithPagination;

class Tasks extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $readyToLoad = false;

    public function loadTasks()
    {
        $this->readyToLoad = true;
    }

    public function getTasks()
    {
        return Task::withCount(['comments', 'likers'])
            ->latest()
            ->paginate(50);
    }

    public function render()
    {
        return view('livewire.staff.tasks', [
            'tasks' => $this->readyToLoad ? $this->getTasks() : [],
            'count' => $this->readyToLoad ? Task::count('id') : [],
        ]);
    }
}
