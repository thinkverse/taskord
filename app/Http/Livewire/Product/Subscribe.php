<?php

namespace App\Http\Livewire\Product;

use App\Notifications\Subscribed;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Subscribe extends Component
{
    public $product;

    public function mount($product)
    {
        $this->product = $product;
    }

    public function subscribeProduct()
    {
        if (Auth::check()) {
            if (Auth::user()->isFlagged) {
                return session()->flash('error', 'Your account is flagged!');
            }
            if (Auth::id() === $this->product->user->id) {
                return session()->flash('error', 'You can\'t subscribe your own product!');
            } else {
                Auth::user()->toggleLike($this->product);
                $this->product->refresh();
                if (Auth::user()->hasLiked($this->product)) {
                    $this->product->user->notify(new Subscribed($this->product, Auth::id()));
                }
            }
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function render()
    {
        return view('livewire.product.subscribe');
    }
}
