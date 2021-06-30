<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\ProfileBadge;

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
}
