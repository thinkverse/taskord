<?php

namespace App\Http\Livewire\Milestone;

use Livewire\Component;
use App\Models\Task;
use App\Models\Milestone;

class Tasks extends Component
{
    public Milestone $milestone;
    public $page;
    public $readyToLoad = false;
    
    public $listeners = [
        'taskAdded' => 'render',
        'taskDeleted' => 'render',
        'taskChecked' => 'render',
    ];
    
    public function mount($milestone, $page)
    {
        $this->milestone = $milestone;
        $this->page = $page ? $page : 1;
    }
    
    public function loadTasks()
    {
        $this->readyToLoad = true;
    }
    
    public function getTasks()
    {
        return Task::select('id', 'task', 'done', 'type', 'created_at', 'done_at', 'user_id', 'product_id', 'source', 'images', 'hidden')
            ->where('milestone_id', $this->milestone->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10, null, null, $this->page);
    }
    
    public function render()
    {
        return view('livewire.milestone.tasks', [
            'tasks' => $this->readyToLoad ? $this->getTasks() : [],
            'page' => $this->page,
        ]);
    }
}
