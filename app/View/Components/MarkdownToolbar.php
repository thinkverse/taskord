<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class MarkdownToolbar extends Component
{
    public $htmlFor;

    public function __construct($htmlFor)
    {
        $this->htmlFor = $htmlFor;
    }

    public function render(): View
    {
        return view('components.markdown-toolbar');
    }
}
