<?php

namespace App\Http\Livewire\Product;

use App\Models\Milestone;
use App\Models\Task;
use Livewire\Component;

class LoadMoreTasks extends Component
{
    public $listeners = [
        'taskAdded' => 'render',
        'taskDeleted' => 'render',
        'taskChecked' => 'render',
    ];

    public Milestone $milestone;
    public $page;
    public $loadMore;
    public $readyToLoad = true;

    public function mount($product, $page = 1)
    {
        $this->milestone = $milestone;
        $this->page = $page + 1;
        $this->loadMore = false;
    }

    public function loadMore()
    {
        $this->loadMore = true;
    }

    public function render()
    {
        if ($this->loadMore) {
            $tasks = Task::select('id', 'task', 'done', 'created_at', 'done_at', 'user_id', 'product_id', 'source', 'images', 'type', 'hidden')
                ->where('milestone_id', $this->milestone->id)
                ->orderBy('created_at', 'desc')
                ->paginate(10, null, null, $this->page);

            return view('livewire.milestone.tasks', [
                'tasks' => $tasks,
            ]);
        } else {
            return view('livewire.load-more');
        }
    }
}
