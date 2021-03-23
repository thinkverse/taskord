<?php

namespace App\Http\Livewire\Home;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Tasks extends Component
{
    public $listeners = [
        'taskAdded' => 'render',
        'taskDeleted' => 'render',
        'taskChecked' => 'render',
        'onlyFollowings' => 'render',
    ];

    public $page;
    public $readyToLoad = false;

    public function mount($page)
    {
        $this->page = $page ? $page : 1;
    }

    public function loadTasks()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        if (Auth::check() && auth()->user()->onlyFollowingsTasks) {
            $userIds = auth()->user()->followings()->pluck('id');
            $userIds->push(auth()->user()->id);
            $tasks = Task::select('id', 'task', 'done', 'type', 'done_at', 'user_id', 'product_id', 'source', 'images', 'hidden')
                ->whereIn('user_id', $userIds)
                ->whereHas('user', function ($q) {
                    $q->where([
                        ['isFlagged', false],
                        ['isPrivate', false],
                    ]);
                })
                ->where('done', true)
                ->orderBy('done_at', 'desc')
                ->paginate(10, null, null, $this->page);
        } else {
            $tasks = Task::select('id', 'task', 'done', 'type', 'done_at', 'user_id', 'product_id', 'source', 'images', 'hidden')
                ->whereHas('user', function ($q) {
                    $q->where([
                        ['isFlagged', false],
                        ['isPrivate', false],
                    ]);
                })
                ->where('done', true)
                ->orderBy('done_at', 'desc')
                ->paginate(10, null, null, $this->page);
        }

        return view('livewire.home.tasks', [
            'tasks' => $this->readyToLoad ? $tasks : [],
            'page' => $this->page,
        ]);
    }
}
