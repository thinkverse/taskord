<?php

namespace App\Http\Livewire\User\Settings;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Products extends Component
{
    public User $user;

    public Collection $products;

    public function mount($user)
    {
        $this->user = $user;

        $this->products = Product::where('user_id', $this->user->id)
            ->orWhereHas('members', function (Builder $query) {
                $query->where('user_id', $this->user->id);
            })->get();
    }

    public function render()
    {
        return view('livewire.user.settings.products');
    }
}
