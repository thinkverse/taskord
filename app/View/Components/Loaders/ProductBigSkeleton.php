<?php

namespace App\View\Components\loaders;

use Illuminate\View\Component;

class ProductBigSkeleton extends Component
{
    public $count;

    public function __construct($count)
    {
        $this->count = $count;
    }

    public function render()
    {
        return view('components.loaders.product-big-skeleton');
    }
}
