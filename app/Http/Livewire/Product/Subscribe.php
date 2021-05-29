<?php

namespace App\Http\Livewire\Product;

use App\Models\Product;
use App\Notifications\Product\Subscribed;
use GrahamCampbell\Throttle\Facades\Throttle;
use Helper;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request;
use Livewire\Component;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;

class Subscribe extends Component
{
    use WithRateLimiting;
    
    public Product $product;

    public function mount($product)
    {
        $this->product = $product;
    }

    public function subscribeProduct()
    {
        try {
            $this->rateLimit(10);
        } catch (TooManyRequestsException $exception) {
            return toast($this, 'error', config('taskord.error.rate-limit'));
        }

        if (Gate::denies('praise', $this->product)) {
            return toast($this, 'error', config('taskord.error.deny'));
        }

        auth()->user()->toggleSubscribe($this->product);
        $this->product->refresh();
        auth()->user()->touch();
        if (auth()->user()->hasSubscribed($this->product)) {
            $this->product->user->notify(new Subscribed($this->product, auth()->user()->id));
        }

        return loggy(request(), 'Product', auth()->user(), 'Toggled product subscribe | Product ID: #'.$this->product->slug);
    }

    public function render()
    {
        return view('livewire.product.subscribe');
    }
}
