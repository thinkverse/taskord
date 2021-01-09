<?php

namespace App\Http\Livewire\Question;

use App\Models\Question;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Livewire\Component;

class Questions extends Component
{
    public $type;
    public $page;
    public $perPage;
    public $readyToLoad = false;

    public function mount($page, $perPage, $type)
    {
        $this->type = $type;
        $this->page = $page ? $page : 1;
        $this->perPage = $perPage ? $perPage : 1;
    }

    public function loadQuestions()
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
        if ($this->type === 'questions.newest') {
            $questions = Question::cacheFor(60 * 60)
                ->whereHas('user', function ($q) {
                    $q->where([
                        ['isFlagged', false],
                    ]);
                })
                ->latest()
                ->get();
        } elseif ($this->type === 'questions.unanswered') {
            $questions = Question::cacheFor(60 * 60)
                ->whereHas('user', function ($q) {
                    $q->where([
                        ['isFlagged', false],
                    ]);
                })
                ->doesntHave('answer')
                ->latest()
                ->get();
        } elseif ($this->type === 'questions.popular') {
            $questions = Question::cacheFor(60 * 60)
                ->withCount('answer')
                ->whereHas('user', function ($q) {
                    $q->where([
                        ['isFlagged', false],
                    ]);
                })
                ->has('answer')
                ->orderBy('answer_count', 'desc')
                ->get();
        }

        return view('livewire.question.questions', [
            'questions' => $this->readyToLoad ? $this->paginate($questions) : [],
            'page' => $this->page,
        ]);
    }
}
