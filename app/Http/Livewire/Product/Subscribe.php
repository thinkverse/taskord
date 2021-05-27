<?php

namespace App\Http\Livewire\Product;

use App\Models\Product;
use App\Notifications\Product\Subscribed;
use GrahamCampbell\Throttle\Facades\Throttle;
use Helper;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class Subscribe extends Component
{
    public Product $product;

    public function mount($product)
    {
        $this->product = $product;
    }

    public function subscribeProduct()
    {
        $throttler = Throttle::get(Request::instance(), 10, 5);
        $throttler->hit();
        if (count($throttler) > 20) {
            Helper::flagAccount(auth()->user());
        }
        if (! $throttler->check()) {
            loggy(request(), 'Throttle', auth()->user(), 'Rate limited while subscribing to a product');

            return toast($this, 'error', 'Your are rate limited, try again later!');
        }

        if (! auth()->check()) {
            return toast($this, 'error', "Oops! You can't perform this action");
        }

        if (! auth()->user()->hasVerifiedEmail()) {
            return toast($this, 'error', 'Your email is not verified!');
        }
        if (auth()->user()->spammy) {
            return toast($this, 'error', 'Your account is flagged!');
        }
        if (auth()->user()->id === $this->product->owner->id) {
            return toast($this, 'error', 'You can\'t subscribe your own product!');
        }

        auth()->user()->toggleSubscribe($this->product);
        $this->product->refresh();
        auth()->user()->touch();
        if (auth()->user()->hasSubscribed($this->product)) {
            $this->product->owner->notify(new Subscribed($this->product, auth()->user()->id));
        }

        return loggy(request(), 'Product', auth()->user(), 'Toggled product subscribe | Product ID: #'.$this->product->slug);
    }

    public function render()
    {
        return view('livewire.product.subscribe');
    }
}
