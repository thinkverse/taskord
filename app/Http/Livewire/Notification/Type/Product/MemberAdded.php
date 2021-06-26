<?php

namespace App\Http\Livewire\Notification\Type\Product;

use App\Models\Product;
use Livewire\Component;
use Illuminate\Contracts\View\View;

class MemberAdded extends Component
{
    public $data;

    public function mount($data)
    {
        $this->data = $data;
    }

    public function render()
    {
        $product = Product::find($this->data['product_id']);

        return view('livewire.notification.type.product.member-added', [
            'product' => $product,
        ]);
    }
}
