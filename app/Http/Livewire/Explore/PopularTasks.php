<?php

namespace App\Http\Livewire\Explore;

use Livewire\Component;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class PopularTasks extends Component
{
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
                ->select('id', 'task', 'done', 'type', 'done_at', 'user_id', 'product_id', 'source', 'images', 'hidden')
                ->whereHas('user', function ($q) {
                    $q->where([
                        ['isFlagged', false],
                        ['isPrivate', false],
                    ]);
                })
                ->where('done', true)
                ->orderBy('done_at', 'desc')
                ->paginate(10, null, null, $this->page);
                
        return view('livewire.explore.popular-tasks', [
            'tasks' => $this->readyToLoad ? $tasks : [],
            'page' => $this->page
        ]);
    }
}
