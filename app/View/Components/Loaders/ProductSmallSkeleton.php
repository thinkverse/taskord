<?php

namespace App\View\Components\Loaders;

use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class ProductSmallSkeleton extends Component
{
    public $count;

    public function __construct($count)
    {
        $this->count = $count;
    }

    public function render()
    {
        return view('components.loaders.product-small-skeleton');
    }
}
