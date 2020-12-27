<?php

namespace App\Http\Livewire\Product;

use App\Models\Product;
use App\Notifications\Subscribed;
use GrahamCampbell\Throttle\Facades\Throttle;
use Helper;
use Illuminate\Support\Facades\Auth;
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
            Helper::flagAccount(Auth::user());
        }
        if (! $throttler->check()) {
            activity()
                ->withProperties(['type' => 'Throttle'])
                ->log('Rate limited while subscribing to a product');

            return $this->alert('error', 'Your are rate limited, try again later!', [
                'showCancelButton' =>  false,
            ]);
        }

        if (Auth::check()) {
            if (! Auth::user()->hasVerifiedEmail()) {
                return $this->alert('warning', 'Your email is not verified!', [
                    'showCancelButton' =>  false,
                ]);
            }
            if (Auth::user()->isFlagged) {
                return $this->alert('error', 'Your account is flagged!', [
                    'showCancelButton' =>  false,
                ]);
            }
            if (Auth::id() === $this->product->owner->id) {
                return $this->alert('warning', 'You can\'t subscribe your own product!', [
                    'showCancelButton' =>  false,
                ]);
            } else {
                Auth::user()->toggleSubscribe($this->product);
                $this->product->refresh();
                Auth::user()->touch();
                if (Auth::user()->hasSubscribed($this->product)) {
                    $this->product->owner->notify(new Subscribed($this->product, Auth::id()));
                }
                activity()
                    ->withProperties(['type' => 'Product'])
                    ->log('Product subscribe was toggled P: #'.$this->product->slug);
            }
        } else {
            return $this->alert('error', 'Forbidden!', [
                'showCancelButton' =>  false,
            ]);
        }
    }

    public function render()
    {
        return view('livewire.product.subscribe');
    }
}
