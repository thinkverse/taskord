<?php

namespace App\Http\Livewire\Comment;

use App\Models\Task;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Livewire\Component;

class Comments extends Component
{
    public $listeners = [
        'refreshComments' => 'render',
    ];

    public Task $task;
    public $page;
    public $perPage;
    public $ready_to_load = false;

    public function mount($task, $page, $perPage)
    {
        $this->task = $task;
        $this->page = $page ? $page : 1;
        $this->perPage = $perPage ? $perPage : 1;
    }

    public function loadComments()
    {
        $this->ready_to_load = true;
    }

    public function getComments()
    {
        return $this->task->comments()
            ->whereHas('user', function ($q) {
                $q->where([
                    ['spammy', false],
                ]);
            })
            ->oldest()
            ->get();
    }

    public function paginate($items, $options = [])
    {
        $page = $this->page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $this->perPage), $items->count(), $this->perPage, $page, $options);
    }

    public function render()
    {
        return view('livewire.comment.comments', [
            'comments' => $this->ready_to_load ? $this->paginate($this->getComments()) : [],
            'page' => $this->page,
        ]);
    }
}
