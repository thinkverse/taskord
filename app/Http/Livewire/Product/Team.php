<?php

namespace App\Http\Livewire\Product;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Team extends Component
{
    public $product;
    public $user;

    public function mount($product, $user)
    {
        $this->product = $product;
        $this->user = $user;
    }

    public function removeMember()
    {
        if (Auth::check()) {
            $this->user->products()->detach($this->product);
        }
    }

    public function render()
    {
        return view('livewire.product.team');
    }
}
