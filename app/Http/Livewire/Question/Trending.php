<?php

namespace App\Http\Livewire\Question;

use App\Models\Question;
use Livewire\Component;
use Illuminate\Contracts\View\View;

class Trending extends Component
{
    public $readyToLoad = false;

    public function loadTrending()
    {
        $this->readyToLoad = true;
    }

    public function getTrending()
    {
        return Question::with(['answers', 'user'])
            ->orderByViews()
            ->has('answers')
            ->take(5)
            ->get()
            ->sortByDesc(function ($question) {
                return $question->answers->count('id');
            });
    }

    public function render()
    {
        return view('livewire.question.trending', [
            'trending' => $this->readyToLoad ? $this->getTrending() : [],
        ]);
    }
}
