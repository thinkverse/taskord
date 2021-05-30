<?php

namespace App\Http\Controllers;

use App\Models\Milestone;

class MilestoneController extends Controller
{
    public function opened()
    {
        return view('milestone.milestones', [
            'type' => 'milestones.opened',
        ]);
    }

    public function closed()
    {
        return view('milestone.milestones', [
            'type' => 'milestones.closed',
        ]);
    }

    public function milestone(Milestone $milestone)
    {
        $response = [
            'type' => 'milestones.milestone',
            'milestone' => $milestone,
        ];
        if (
            auth()->check() && auth()->user()->id === $milestone->user->id or
            auth()->check() && auth()->user()->staff_mode
        ) {
            return view('milestone/milestone', $response);
        }

        if ($milestone->user->spammy or $milestone->user->is_private) {
            return abort(404);
        }

        return view('milestone/milestone', $response);
    }

    public function edit(Milestone $milestone)
    {
        if (
            auth()->check() && auth()->user()->id === $milestone->user->id or
            auth()->check() && auth()->user()->staff_mode
        ) {
            return view('milestone.edit', [
                'milestone' => $milestone,
            ]);
        }

        return abort(404);
    }

    public function popover(Milestone $milestone)
    {
        return view('milestone.popover', [
            'milestone' => $milestone,
        ]);
    }
}
