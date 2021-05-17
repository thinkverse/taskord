<?php

namespace App\Http\Livewire\Milestone;

use App\Models\Milestone;
use Livewire\Component;

class CreateMilestone extends Component
{
    public $name;
    public $description;
    public $start_date;
    public $end_date;

    public function submit()
    {
        if (auth()->check()) {
            $this->validate([
                'name' => ['required', 'min:5', 'max:100'],
                'description' => ['required', 'min:3', 'max:10000'],
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
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
            ]);
            auth()->user()->touch();

            loggy(request(), 'Milestone', auth()->user(), 'Created a new milestone | Milestone ID: '.$milestone->id);
            $this->flash('success', 'Milestone has been created!');

            return redirect()->route('milestones.milestone', ['milestone' => $milestone]);
        } else {
            $this->alert('error', 'Forbidden!');
        }
    }
}
