<?php

namespace App\Http\Livewire\Milestone;

use App\Models\Milestone;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreateMilestone extends Component
{
    public $name;
    public $description;

    public function submit()
    {
        if (Auth::check()) {
            $this->validate([
                'name' => 'required|min:5|max:100',
                'description' => 'required|min:3|max:10000',
            ]);

            if (! auth()->user()->hasVerifiedEmail()) {
                return $this->alert('warning', 'Your email is not verified!');
            }

            if (auth()->user()->isFlagged) {
                return $this->alert('error', 'Your account is flagged!');
            }

            $milestone = Milestone::create([
                'user_id' =>  auth()->user()->id,
                'name' => $this->name,
                'description' => $this->description,
            ]);
            auth()->user()->touch();

            loggy(request()->ip(), 'Milestone', auth()->user(), 'Created a new milestone | Milestone ID: '.$milestone->id);
            $this->flash('success', 'Milestone has been created!');

            return redirect()->route('milestones.milestone', ['id' => $milestone->id]);
        } else {
            $this->alert('error', 'Forbidden!');
        }
    }
}
