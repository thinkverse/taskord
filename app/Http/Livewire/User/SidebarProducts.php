<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use App\Models\User;

class SidebarProducts extends Component
{
    public User $user;

    public function mount($user)
    {
        $this->user = $user;
    }

    public function loadProducts()
    {
        $this->readyToLoad = true;
    }

    public function getProducts()
    {
        return $this->user->ownedProducts()
            ->with(['user', 'members'])
            ->paginate(10);
    }

    public function render()
    {
        return view('livewire.user.sidebar-products', [
            'products' => $this->readyToLoad ? $this->getProducts() : [],
        ]);
    }
}
