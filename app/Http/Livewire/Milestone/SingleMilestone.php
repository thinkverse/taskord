<?php

namespace App\Http\Livewire\Milestone;

use App\Models\Milestone;
use GrahamCampbell\Throttle\Facades\Throttle;
use Helper;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class SingleMilestone extends Component
{
    public Milestone $milestone;
    public $type;

    public function mount($milestone, $type)
    {
        $this->milestone = $milestone;
        $this->type = $type;
    }

    public function togglePraise()
    {
        $throttler = Throttle::get(Request::instance(), 30, 5);
        $throttler->hit();
        if (count($throttler) > 30) {
            Helper::flagAccount(auth()->user());
        }
        if (! $throttler->check()) {
            loggy(request(), 'Throttle', auth()->user(), 'Rate limited while praising the milestone');

            return $this->alert('error', 'Your are rate limited, try again later!');
        }

        if (auth()->check()) {
            if (! auth()->user()->hasVerifiedEmail()) {
                return $this->alert('warning', 'Your email is not verified!');
            }

            if (auth()->user()->isFlagged) {
                return $this->alert('error', 'Your account is flagged!');
            }
            if (auth()->user()->id === $this->milestone->user->id) {
                return $this->alert('warning', 'You can\'t praise your own milestone!');
            }
            Helper::togglePraise($this->milestone, 'MILESTONE');
            loggy(request(), 'Milestone', auth()->user(), 'Toggled milestone praise | Milestone ID: '.$this->milestone->id);
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }

    public function hide()
    {
        if (auth()->check()) {
            if (auth()->user()->isStaff and auth()->user()->staffShip) {
                Helper::hide($this->milestone);
                loggy(request(), 'Admin', auth()->user(), 'Toggled hide milestone | Milestone ID: '.$this->milestone->id);

                return $this->alert('success', 'Milestone is hidden from public!');
            } else {
                return $this->alert('error', 'Forbidden!');
            }
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }

    public function toggleStatus()
    {
        if (auth()->check()) {
            if ($this->milestone->status) {
                $this->milestone->status = false;
                $this->milestone->save();
                loggy(request(), 'Milestone', auth()->user(), 'Closed the milestone | Milestone ID: '.$this->milestone->id);

                return redirect()->route('milestones.milestone', ['milestone' => $this->milestone]);
            } else {
                $this->milestone->status = true;
                $this->milestone->save();
                loggy(request(), 'Milestone', auth()->user(), 'Opened the milestone | Milestone ID: '.$this->milestone->id);

                return redirect()->route('milestones.milestone', ['milestone' => $this->milestone]);
            }
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }

    public function deleteMilestone()
    {
        if (auth()->check()) {
            if (auth()->user()->isFlagged) {
                return $this->alert('error', 'Your account is flagged!');
            }

            if (auth()->user()->staffShip or auth()->user()->id === $this->milestone->user_id) {
                loggy(request(), 'Milestone', auth()->user(), 'Deleted a milestone | Milestone ID: '.$this->milestone->id);
                $this->milestone->delete();
                auth()->user()->touch();
                $this->flash('success', 'Milestone has been deleted successfully!');

                return redirect()->route('milestones.opened');
            } else {
                $this->alert('error', 'Forbidden!');
            }
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }
}
