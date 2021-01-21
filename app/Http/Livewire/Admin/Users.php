<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $readyToLoad = false;

    public function loadUsers()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        $users = User::latest('last_active')->paginate(50);
        $count = User::count('id');

        return view('livewire.admin.users', [
            'users' => $this->readyToLoad ? $users : [],
            'count' => $this->readyToLoad ? $count : [],
        ]);
    }
}
