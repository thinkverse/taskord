<?php

namespace App\View\Components\Shared;

use App\Models\User;
use Illuminate\View\Component;
use Illuminate\View\View;

class UserLabelWithBio extends Component
{
    public User $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function render(): View
    {
        return view('components.shared.user-label-with-bio');
    }
}
