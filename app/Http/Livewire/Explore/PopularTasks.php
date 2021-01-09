<?php

namespace App\Http\Livewire\Explore;

use App\Models\Task;
use Livewire\Component;

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
        $tasks = Task::cacheFor(60 * 60)
                ->withCount(['comments', 'likers'])
                ->whereHas('user', function ($q) {
                    $q->where([
                        ['isFlagged', false],
                        ['isPrivate', false],
                    ]);
                })
                ->latest()
                ->take(20)
                ->has('comments')
                ->get()
                ->sortByDesc('likers_count')
                ->sortByDesc('comments_count')
                ->shuffle();

        return view('livewire.explore.popular-tasks', [
            'tasks' => $this->readyToLoad ? $tasks : [],
            'page' => $this->page,
        ]);
    }
}
