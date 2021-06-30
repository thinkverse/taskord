<?php

namespace App\Http\Livewire\Badges;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Livewire\Component;
use App\Models\ProfileBadge;

class EditBadge extends Component
{
    public ProfileBadge $badge;
    public $title;
    public $icon;
    public $color;

    public function mount($badge)
    {
        $this->badge = $badge;
        $this->title = $badge->title;
        $this->icon = $badge->icon;
        $this->color = "";
    }

    public function submit()
    {
        if (Gate::denies('create')) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        $this->validate([
            'title' => ['required', 'min:3', 'max:30'],
            'color' => ['required', 'max:10'],
            'icon' => ['required', 'active_url'],
        ]);

        $titleSlug = Str::slug(Str::limit($this->title, 240));
        $randomForSlug = Str::lower(Str::random(10));

        $badge = auth()->user()->profileBadges()->create([
            'slug' => $titleSlug.'-'.$randomForSlug,
            'title' => trim($this->title),
            'color' => '#'.trim($this->color),
            'icon' => trim($this->icon),
        ]);

        $this->emit('refreshBadges');
        loggy(request(), 'Badge', auth()->user(), "Created a new badge | Badge ID: {$badge->id}");

        return redirect()->route('badges.badge', ['slug' => $badge->slug]);
    }

    public function render(): View
    {
        return view('livewire.badges.edit-badge');
    }
}
