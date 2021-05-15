<?php

namespace App\View\Components\Shared;

use Illuminate\View\Component;

class User extends Component
{
    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.shared.user');
    }
}
