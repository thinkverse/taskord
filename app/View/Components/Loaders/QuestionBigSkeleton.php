<?php

namespace App\View\Components\loaders;

use Illuminate\View\Component;

class QuestionBigSkeleton extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.loaders.question-big-skeleton');
    }
}
