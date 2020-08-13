<?php

namespace App\Http\Livewire\Task;

use App\Models\Comment;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Livewire\Component;

class LoadMore extends Component
{
    public $task;
    public $page;
    public $perPage;
    public $loadMore;

    public function mount($task, $page = 1, $perPage = 1)
    {
        $this->task = $task;
        $this->page = $page + 1; //increment the page
        $this->perPage = $perPage;
        $this->loadMore = false; //show the button
    }

    public function paginate($items, $options = [])
    {
        $page = $this->page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $this->perPage), $items->count(), $this->perPage, $page, $options);
    }

    public function loadMore()
    {
        $this->loadMore = true;
    }

    public function render()
    {
        if ($this->loadMore) {
            $comments = Comment::cacheFor(60 * 60)
                ->where('task_id', $this->task->id)
                    ->whereHas('user', function ($q) {
                    $q->where([
                        ['isFlagged', false],
                    ]);
                })
                ->orderBy('created_at', 'DESC')
                ->get();

            return view('livewire.task.comments', [
                'comments' => $this->paginate($comments),
            ]);
        } else {
            return view('livewire.load-more');
        }
    }
}
