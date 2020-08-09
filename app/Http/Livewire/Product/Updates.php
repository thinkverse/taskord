<?php

namespace App\Http\Livewire\Product;

use App\ProductUpdate;
use Livewire\Component;

class Updates extends Component
{
    public $product;

    public function mount($product)
    {
        $this->product = $product;
    }

    public function render()
    {
        $updates = ProductUpdate::cacheFor(60 * 60)
            ->where('product_id', $this->product->id)
            ->latest()
            ->paginate(20);

        return view('livewire.product.updates', [
            'updates' => $updates,
        ]);
    }
}
