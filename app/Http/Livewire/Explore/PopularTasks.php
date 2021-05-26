<?php

namespace App\Http\Livewire\Explore;

use App\Models\Task;
use Livewire\Component;

class PopularTasks extends Component
{
    public $listeners = [
        'refreshTasks' => 'render',
    ];

    public $readyToLoad = false;

    public function loadPopularTasks()
    {
        $this->readyToLoad = true;
    }

    public function getPopularTasks()
    {
        return Task::whereHas('user', function ($q) {
                    $q->where([
                        ['spammy', false],
                        ['is_private', false],
                    ]);
                })
                ->latest('created_at')
                ->take(50)
                ->has('comments')
                ->limit(10)
                ->get()
                ->sortByDesc('likers_count')
                ->sortByDesc('comments_count')
                ->shuffle();
    }

    public function render()
    {
        return view('livewire.explore.popular-tasks', [
            'tasks' => $this->readyToLoad ? $this->getPopularTasks() : [],
        ]);
    }
}
