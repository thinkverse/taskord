<?php

namespace App\Http\Livewire\Answer;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Livewire\Component;

class Answers extends Component
{
    public $listeners = [
        'answerAdded' => 'render',
        'answerDeleted' => 'render',
    ];

    public Question $question;
    public $page;
    public $perPage;
    public $readyToLoad = false;

    public function mount($question, $page, $perPage)
    {
        $this->question = $question;
        $this->page = $page ? $page : 1;
        $this->perPage = $perPage ? $perPage : 1;
    }

    public function loadAnswers()
    {
        $this->readyToLoad = true;
    }

    public function paginate($items, $options = [])
    {
        $page = $this->page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $this->perPage), $items->count(), $this->perPage, $page, $options);
    }

    public function render()
    {
        $answers = Answer::where('question_id', $this->question->id)
            ->whereHas('user', function ($q) {
                $q->where([
                    ['isFlagged', false],
                ]);
            })
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('livewire.answer.answers', [
            'answers' => $this->readyToLoad ? $this->paginate($answers) : [],
            'page' => $this->page,
        ]);
    }
}
