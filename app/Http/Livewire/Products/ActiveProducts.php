<?php

namespace App\Http\Livewire\Products;

use App\Models\Product;
use Livewire\Component;
use Illuminate\Contracts\View\View;

class ActiveProducts extends Component
{
    public $readyToLoad = false;

    public function loadActiveProducts()
    {
        $this->readyToLoad = true;
    }

    public function getActiveProducts()
    {
        return Product::with(['user', 'members', 'tasks'])
            ->whereLaunched(true)
            ->take(10)
            ->get()
            ->sortByDesc(function ($product) {
                return $product->tasks->count('id');
            });
    }

    public function render()
    {
        return view('livewire.products.active-products', [
            'products' => $this->readyToLoad ? $this->getActiveProducts() : [],
        ]);
    }
}
