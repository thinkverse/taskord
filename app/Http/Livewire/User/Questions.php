<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Questions extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public User $user;
    public $readyToLoad = false;

    public function mount($user)
    {
        $this->user = $user;
    }

    public function loadQuestions()
    {
        $this->readyToLoad = true;
    }

    public function getQuestions()
    {
        return $this->user->questions()
            ->with('answers.user')
            ->latest()
            ->paginate(10);
    }

    public function render()
    {
        return view('livewire.user.questions', [
            'questions' => $this->readyToLoad ? $this->getQuestions() : [],
        ]);
    }
}
