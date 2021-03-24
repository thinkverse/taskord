<?php

namespace App\Http\Livewire\Tasks;

use App\Models\Task;
use Livewire\Component;

class AllTime extends Component
{
    public $listeners = [
        'taskChecked' => 'render',
        'taskAdded' => 'render',
        'taskDeleted' => 'render',
    ];
    public $readyToLoad = false;

    public function loadAllTimeTasks()
    {
        $this->readyToLoad = true;
    }

    public function getAllTimeTasks()
    {
        return Task::select('id', 'task', 'done', 'images', 'user_id', 'created_at', 'due_at', 'type', 'product_id')
            ->where('user_id', auth()->user()->id)
            ->where('done', false)
            ->latest('due_at')
            ->get();
    }

    public function render()
    {
        return view('livewire.tasks.all-time', [
            'tasks' => $this->readyToLoad ? $this->getAllTimeTasks() : [],
        ]);
    }
}
