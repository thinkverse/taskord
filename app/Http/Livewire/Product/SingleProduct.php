<?php

namespace App\Http\Livewire\Product;

use App\Models\Product;
use Livewire\Component;

class SingleProduct extends Component
{
    public Product $product;

    public function mount($product)
    {
        $this->product = $product;
    }

    public function render()
    {
        return view('livewire.product.single-product');
    }
}
