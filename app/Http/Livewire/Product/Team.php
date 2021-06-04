<?php

namespace App\Http\Livewire\Product;

use App\Models\Product;
use App\Models\User;
use App\Notifications\Product\MemberRemoved;
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
        if (! auth()->check()) {
            return toast($this, 'error', config('taskord.error.deny'));
        }

        $this->user->products()->detach($this->product);
        $this->user->notify(new MemberRemoved($this->product, auth()->user()->id));
        loggy(request(), 'Product', auth()->user(), "Removed @{$this->user->username} from the product | Product ID: {$this->product->id}");

        return redirect()->route('product.done', ['slug' => $this->product->slug]);
    }
}
