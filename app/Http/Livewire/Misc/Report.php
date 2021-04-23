<?php

namespace App\Http\Livewire\Misc;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Report extends Component
{
    public $title;
    public $description;
    
    public function createIssue()
    {
        if (Auth::check()) {
            loggy(request()->ip(), 'Issue', auth()->user(), 'Reported a new issue');
            return $this->alert('success', 'Issue has been reported successfully!');
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }

    public function render()
    {
        return view('livewire.misc.report');
    }
}
