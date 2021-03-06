<?php

namespace App\Http\Livewire\User;

use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Reputations extends Component
{
    use WithPagination;

    public $readyToLoad = false;
    protected $paginationTheme = 'bootstrap';

    public function loadReputations()
    {
        $this->readyToLoad = true;
    }

    public function getReputations()
    {
        return DB::table('reputations')
            ->wherePayeeId(auth()->user()->id)
            ->latest()
            ->paginate(50);
    }

    public function render(): View
    {
        return view('livewire.user.reputations', [
            'points' => $this->readyToLoad ? $this->getReputations() : [],
        ]);
    }
}
