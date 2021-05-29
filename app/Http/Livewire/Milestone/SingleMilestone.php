<?php

namespace App\Http\Livewire\Milestone;

use App\Models\Milestone;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Helper;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class SingleMilestone extends Component
{
    use WithRateLimiting;

    public Milestone $milestone;
    public $type;

    public function mount($milestone, $type)
    {
        $this->milestone = $milestone;
        $this->type = $type;
    }

    public function togglePraise()
    {
        try {
            $this->rateLimit(50);
        } catch (TooManyRequestsException $exception) {
            return toast($this, 'error', config('taskord.error.rate-limit'));
        }

        if (Gate::denies('praise/subscribe', $this->milestone)) {
            return toast($this, 'error', config('taskord.error.deny'));
        }

        Helper::togglePraise($this->milestone, 'MILESTONE');

        return loggy(request(), 'Milestone', auth()->user(), 'Toggled milestone praise | Milestone ID: '.$this->milestone->id);
    }

    public function hide()
    {
        if (Gate::denies('staff_mode')) {
            return toast($this, 'error', config('taskord.error.deny'));
        }

        Helper::hide($this->milestone);
        loggy(request(), 'Staff', auth()->user(), 'Toggled hide milestone | Milestone ID: '.$this->milestone->id);

        return toast($this, 'success', 'Milestone is hidden from public!');
    }

    public function toggleStatus()
    {
        if (! auth()->check()) {
            return toast($this, 'error', config('taskord.error.deny'));
        }

        if ($this->milestone->status) {
            $this->milestone->status = false;
            $this->milestone->save();
            loggy(request(), 'Milestone', auth()->user(), 'Closed the milestone | Milestone ID: '.$this->milestone->id);

            return redirect()->route('milestones.milestone', ['milestone' => $this->milestone]);
        }

        $this->milestone->status = true;
        $this->milestone->save();
        loggy(request(), 'Milestone', auth()->user(), 'Opened the milestone | Milestone ID: '.$this->milestone->id);

        return redirect()->route('milestones.milestone', ['milestone' => $this->milestone]);
    }

    public function deleteMilestone()
    {
        if (Gate::denies('edit/delete', $this->milestone)) {
            return toast($this, 'error', config('taskord.error.deny'));
        }

        loggy(request(), 'Milestone', auth()->user(), 'Deleted a milestone | Milestone ID: '.$this->milestone->id);
        $this->milestone->delete();
        auth()->user()->touch();

        return redirect()->route('milestones.opened');
    }
}
