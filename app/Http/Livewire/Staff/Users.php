<?php

namespace App\Http\Livewire\Staff;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Contracts\View\View;

class Users extends Component
{
    use WithPagination;

    public $query;
    public $readyToLoad = false;
    protected $paginationTheme = 'bootstrap';

    public function loadUsers()
    {
        $this->readyToLoad = true;
    }

    public function getUsers()
    {
        return User::search($this->query)
            ->latest('last_active')
            ->paginate(20);
    }

    public function render()
    {
        return view('livewire.staff.users', [
            'users' => $this->readyToLoad ? $this->getUsers() : [],
            'count' => $this->readyToLoad ? User::count('id') : [],
        ]);
    }
}
