<?php

namespace App\Http\Controllers;

use App\Models\ProfileBadge;
use Illuminate\View\View;

class BadgeController extends Controller
{
    public function badge($slug): View
    {
        $badge = ProfileBadge::where('slug', $slug)
            ->with(['user'])
            ->firstOrFail();

        return view('badges.badge', [
            'badge' => $badge,
        ]);
    }

    public function edit($slug): View
    {
        $badge = ProfileBadge::where('slug', $slug)
            ->with(['user'])
            ->firstOrFail();

        return view('badges.edit', [
            'badge' => $badge,
        ]);
    }
}
