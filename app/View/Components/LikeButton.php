<?php

namespace App\View\Components;

use Illuminate\View\Component;

class LikeButton extends Component
{
    public $entity;

    public function __construct($entity)
    {
        $this->entity = $entity;
    }

    public function render()
    {
        return view('components.like-button');
    }
}
