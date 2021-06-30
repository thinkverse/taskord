<?php

namespace App\Http\Livewire\Badges;

use App\Actions\CreateNewTask;
use App\Rules\Repo;
use App\Rules\ReservedSlug;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Intervention\Image\Facades\Image;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateBadge extends Component
{
    public $title;
    public $icon;
    public $color;

    public function submit()
    {
        if (Gate::denies('create')) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        $this->validate([
            'title' => ['required', 'min:3', 'max:30'],
            'color' => ['required', 'max:160'],
            'icon' => ['required', 'active_url'],
        ]);

        $badge = auth()->user()->profileBadges()->create([
            'title' => trim($this->title),
            'color' => trim($this->color),
            'icon' => trim($this->icon),
        ]);

        $this->emit('refreshBadges');
        loggy(request(), 'Badge', auth()->user(), "Created a new badge | Badge ID: {$badge->id}");

        return redirect()->route('badges.badges', ['slug' => $product->slug]);
    }

    public function render(): View
    {
        return view('livewire.badges.create-badge');
    }
}
