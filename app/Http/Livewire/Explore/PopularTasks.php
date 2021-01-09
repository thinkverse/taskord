<?php

namespace App\Http\Livewire\Explore;

use App\Models\Task;
use Livewire\Component;
use Multicaret\Acquaintances\Models\InteractionRelation;

class PopularTasks extends Component
{
    public $listeners = [
        'taskDeleted' => 'render',
        'taskChecked' => 'render',
    ];

    public $page;
    public $readyToLoad = false;

    public function mount($page)
    {
        $this->page = $page ? $page : 1;
    }

    public function loadPopularTasks()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        $tasks = InteractionRelation::popular(Task::class)
            ->paginate(10, null, null, $this->page);

        return view('livewire.explore.popular-tasks', [
            'tasks' => $this->readyToLoad ? $tasks : [],
            'page' => $this->page,
        ]);
    }
}
