<?php

namespace App\Http\Livewire\Explore;

use App\Models\Task;
use Livewire\Component;
use Multicaret\Acquaintances\Models\InteractionRelation;

class LoadMoreTasks extends Component
{
    public $listeners = [
        'taskDeleted' => 'render',
        'taskChecked' => 'render',
    ];

    public $page;
    public $loadMore;
    public $readyToLoad = true;

    public function mount($page = 1)
    {
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
            $tasks = InteractionRelation::popular(Task::class)
                ->paginate(10, null, null, $this->page);

            return view('livewire.explore.popular-tasks', [
                'tasks' => $tasks,
            ]);
        } else {
            return view('livewire.load-more');
        }
    }
}
