<?php

namespace App\Http\Livewire\Product;

use App\Models\Product;
use App\Models\User;
use App\Notifications\Product\MemberRemoved;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Team extends Component
{
    public Product $product;
    public User $user;

    public function mount($product, $user)
    {
        $this->product = $product;
        $this->user = $user;
    }

    public function removeMember()
    {
        if (auth()->check()) {
            $this->user->products()->detach($this->product);
            $this->user->notify(new MemberRemoved($this->product, auth()->user()->id));
            loggy(request(), 'Product', auth()->user(), 'Removed @'.$this->user->username.' from #'.$this->product->slug);
            $this->flash('success', 'User has been removed from the team!');

            return redirect()->route('product.done', ['slug' => $this->product->slug]);
        }
    }
}
