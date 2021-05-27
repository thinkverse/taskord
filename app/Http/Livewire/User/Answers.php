<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Answers extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public User $user;
    public $readyToLoad = false;

    public function mount($user)
    {
        $this->user = $user;
    }

    public function loadAnswers()
    {
        $this->readyToLoad = true;
    }

    public function getAnswers()
    {
        return $this->user->answers()
            ->with('question.user')
            ->latest()
            ->paginate(10);
    }

    public function render()
    {
        return view('livewire.user.answers', [
            'answers' => $this->readyToLoad ? $this->getAnswers() : [],
        ]);
    }
}
