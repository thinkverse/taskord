<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class LikeButton extends Component
{
    public $entity;

    public function __construct($entity)
    {
        $this->entity = $entity;
    }

    public function render(): View
    {
        return view('components.like-button');
    }
}
