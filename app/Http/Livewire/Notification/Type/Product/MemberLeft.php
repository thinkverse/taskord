<?php

namespace App\Http\Livewire\Notification\Type\Product;

use App\Models\Product;
use Livewire\Component;
use Illuminate\Contracts\View\View;

class MemberLeft extends Component
{
    public $data;

    public function mount($data)
    {
        $this->data = $data;
    }

    public function render(): View
    {
        $product = Product::find($this->data['product_id']);

        return view('livewire.notification.type.product.member-left', [
            'product' => $product,
        ]);
    }
}
