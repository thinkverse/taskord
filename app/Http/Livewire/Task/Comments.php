<?php

namespace App\Http\Livewire\Task;

use App\Models\Comment;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Livewire\Component;

class Comments extends Component
{
    public $listeners = [
        'commentAdded' => 'render',
        'commentDeleted' => 'render',
    ];

    public $task;
    public $page;
    public $perPage;

    public function mount($task, $page, $perPage)
    {
        $this->task = $task;
        $this->page = $page ? $page : 1;
        $this->perPage = $perPage ? $perPage : 1;
    }

    public function paginate($items, $options = [])
    {
        $page = $this->page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $this->perPage), $items->count(), $this->perPage, $page, $options);
    }

    public function render()
    {
        $comments = Comment::where('task_id', $this->task->id)
            ->whereHas('user', function ($q) {
                $q->where([
                    ['isFlagged', false],
                ]);
            })
            ->oldest()
            ->get();

        return view('livewire.task.comments', [
            'comments' => $this->paginate($comments),
            'page' => $this->page,
        ]);
    }
}
