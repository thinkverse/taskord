<?php

namespace App\Http\Livewire\Milestone;

use App\Models\Milestone;
use Livewire\Component;

class EditMilestone extends Component
{
    public Milestone $milestone;
    public $name;
    public $description;
    public $startDate;
    public $endDate;

    protected $rules = [
        'name' => ['required', 'min:5', 'max:150'],
        'description' => ['required', 'min:3', 'max:10000'],
    ];

    public function mount($milestone)
    {
        $this->milestone = $milestone;
        $this->name = $milestone->name;
        $this->description = $milestone->description;
        $this->startDate = $milestone->start_date ? carbon($milestone->start_date)->format('Y-m-d') : null;
        $this->endDate = $milestone->end_date ? carbon($milestone->end_date)->format('Y-m-d') : null;
    }

    public function updated($field)
    {
        if (! auth()->check()) {
            return toast($this, 'error', "Oops! You can't perform this action");
        }

        $this->validateOnly($field);
    }

    public function submit()
    {
        if (! auth()->check()) {
            return toast($this, 'error', "Oops! You can't perform this action");
        }

        $this->validate();

        if (! auth()->user()->hasVerifiedEmail()) {
            return toast($this, 'error', 'Your email is not verified!');
        }

        if (auth()->user()->spammy) {
            return toast($this, 'error', 'Your account is flagged!');
        }

        $milestone = Milestone::where('id', $this->milestone->id)->firstOrFail();

        if (auth()->user()->staff_mode or auth()->user()->id === $milestone->user_id) {
            $milestone->name = $this->name;
            $milestone->description = $this->description;
            $milestone->start_date = $this->startDate ? $this->startDate : null;
            $milestone->end_date = $this->startDate ? $this->endDate : null;
            $milestone->save();
            auth()->user()->touch();

            loggy(request(), 'Milestone', auth()->user(), 'Updated a milestone | Milestone ID: '.$milestone->id);

            return redirect()->route('milestones.milestone', ['milestone' => $milestone]);
        }

        return toast($this, 'error', "Oops! You can't perform this action");
    }
}
