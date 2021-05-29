<?php

namespace App\Http\Livewire\Product\Update;

use App\Models\ProductUpdate;
use GrahamCampbell\Throttle\Facades\Throttle;
use Helper;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request;
use Livewire\Component;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;

class SingleUpdate extends Component
{
    use WithRateLimiting;
    
    public ProductUpdate $update;

    public function mount($update)
    {
        $this->update = $update;
    }

    // TODO
    public function togglePraise()
    {
        try {
            $this->rateLimit(10);
        } catch (TooManyRequestsException $exception) {
            return toast($this, 'error', config('taskord.error.rate-limit'));
        }

        if (Gate::denies('praise', $this->update)) {
            return toast($this, 'error', config('taskord.error.deny'));
        }

        if (auth()->user()->hasLiked($this->update)) {
            auth()->user()->unlike($this->update);
            $this->update->refresh();

            return auth()->user()->touch();
        }
        auth()->user()->like($this->update);
        $this->update->refresh();

        return auth()->user()->touch();
    }

    public function deleteUpdate()
    {
        if (! auth()->check()) {
            return toast($this, 'error', config('taskord.error.deny'));
        }

        if (auth()->user()->spammy) {
            return toast($this, 'error', 'Your account is flagged!');
        }

        if (auth()->user()->staff_mode or auth()->user()->id === $this->update->user->id) {
            loggy(request(), 'Product', auth()->user(), 'Deleted a product update on #'.$this->update->product->slug.' | Update ID: '.$this->update->id);
            $this->update->delete();

            return $this->emitUp('refreshProduct');
        }

        return toast($this, 'error', config('taskord.error.deny'));
    }
}
