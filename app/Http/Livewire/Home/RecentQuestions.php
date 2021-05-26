<?php

namespace App\Http\Livewire\Home;

use App\Models\Question;
use Livewire\Component;

class RecentQuestions extends Component
{
    public $readyToLoad = false;

    public function loadRecentQuestions()
    {
        $this->readyToLoad = true;
    }

    public function getRecentQuestions()
    {
        return Question::withCount('answers')
            ->orderBy('created_at', 'DESC')
            ->take(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.home.recent-questions', [
            'recent_questions' => $this->readyToLoad ? $this->getRecentQuestions() : [],
        ]);
    }
}
