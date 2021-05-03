<?php

namespace App\Http\Livewire\Product;

use App\Models\Product;
use App\Models\ProductUpdate;
use Livewire\Component;

class Updates extends Component
{
    public Product $product;

    public $listeners = [
        'updateDeleted' => 'render',
    ];

    public function mount($product)
    {
        $this->product = $product;
    }

    public function render()
    {
        $updates = $this->product->product_updates()
            ->latest()
            ->paginate(10);

        return view('livewire.product.updates', [
            'updates' => $updates,
        ]);
    }
}
