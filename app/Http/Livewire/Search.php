<?php

namespace App\Http\Livewire;

use App\Models\Product;
use App\Models\Question;
use App\Models\Task;
use App\Models\User;
use Livewire\Component;

class Search extends Component
{
    public $query;
    public $tasks;
    public $users;
    public $products;
    public $questions;

    public function mount()
    {
        $this->query = '';
    }

    public function updatedQuery()
    {
        $this->tasks = Task::select('id', 'task', 'done', 'hidden', 'user_id')
            ->with(['user'])
            ->whereHas('user', function ($q) {
                $q->where([
                    ['spammy', false],
                    ['is_private', false],
                ]);
            })
            ->whereHidden(false)
            ->search($this->query)
            ->take(3)
            ->get();
        $this->users = User::where('spammy', 'false')
            ->search($this->query)
            ->take(3)
            ->get();
        $this->products = Product::select('slug', 'name', 'avatar', 'user_id')
            ->with(['user'])
            ->search($this->query)
            ->take(3)
            ->get();
        $this->questions = Question::select('id', 'slug', 'title', 'user_id')
            ->with(['user'])
            ->whereHas('user', function ($q) {
                $q->where([
                    ['spammy', false],
                ]);
            })
            ->whereHidden(false)
            ->search($this->query)
            ->take(3)
            ->get();
    }
}
