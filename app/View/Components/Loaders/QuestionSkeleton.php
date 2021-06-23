<?php

namespace App\View\Components\Loaders\Home;

use Illuminate\View\Component;

class QuestionSkeleton extends Component
{
    public $count;

    public function __construct($count)
    {
        $this->count = $count;
    }

    public function render()
    {
        return view('components.loaders.home.question-skeleton');
    }
}
