<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Followers extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public User $user;
    public $readyToLoad = false;

    public function loadFollowers()
    {
        $this->readyToLoad = true;
    }

    public function getFollowers()
    {
        return $this->user->followers()->paginate(10);
    }

    public function mount($user)
    {
        $this->user = $user;
    }

    public function render()
    {
        return view('livewire.user.followers', [
            'followers' => $this->readyToLoad ? $this->getFollowers() : [],
        ]);
    }
}
