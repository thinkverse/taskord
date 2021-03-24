<?php

namespace App\Http\Livewire\Tasks;

use App\Models\Task;
use Livewire\Component;

class Today extends Component
{
    public $listeners = [
        'taskChecked' => 'render',
        'taskAdded' => 'render',
        'taskDeleted' => 'render',
    ];
    public $readyToLoad = false;

    public function loadTodayTasks()
    {
        $this->readyToLoad = true;
    }

    public function getTodayTasks()
    {
        return Task::select('id', 'task', 'done', 'images', 'user_id', 'created_at', 'due_at', 'type', 'product_id')
            ->where('user_id', auth()->user()->id)
            ->whereDate('created_at', carbon('today'))
            ->where('done', false)
            ->latest('due_at')
            ->get();
    }

    public function render()
    {
        return view('livewire.tasks.today', [
            'tasks' => $this->readyToLoad ? $this->getTodayTasks() : [],
        ]);
    }
}
