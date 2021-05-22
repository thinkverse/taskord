<?php

namespace App\Http\Livewire\User\Settings;

use App\Models\User;
use App\Models\Webhook;
use GrahamCampbell\Throttle\Facades\Throttle;
use Helper;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use Livewire\Component;

class Integrations extends Component
{
    public User $user;
    public $name;
    public $product;
    public $type = 'web';

    public $listeners = [
        'refreshIntegrations' => 'render',
    ];

    public function mount($user)
    {
        $this->user = $user;
    }

    public function submit()
    {
        $throttler = Throttle::get(Request::instance(), 5, 5);
        $throttler->hit();
        if (count($throttler) > 10) {
            Helper::flagAccount(auth()->user());
        }
        if (! $throttler->check()) {
            loggy(request(), 'Throttle', auth()->user(), 'Rate limited while creating an API integration');

            return Helper::toast($this, 'error', 'Your are rate limited, try again later!',
            ]);
        }

        if (auth()->check()) {
            if (auth()->user()->id === $this->user->id) {
                $this->validate([
                    'name' => ['required', 'min:2', 'max:20'],
                    'product' => ['nullable'],
                ]);

                if (auth()->user()->isFlagged) {
                    return $this->dispatchBrowserEvent('toast', [
                        'type' => 'error',
                        'body' => 'Your account is flagged!',
                    ]);
                }

                if (auth()->user()->id === $this->user->id) {
                    $webhook = auth()->user()->webhooks()->create([
                        'name' => $this->name,
                        'product_id' => $this->product,
                        'token' => Str::uuid(),
                        'type' => $this->type,
                    ]);
                    $this->name = '';
                    $this->product = '';
                    session()->flash('created', $webhook);
                    loggy(request(), 'User', auth()->user(), 'Created a new webhook | Webhook ID: '.$webhook->id);

                    return $this->dispatchBrowserEvent('toast', [
                        'type' => 'success',
                        'body' => 'New webhook has been created!',
                    ]);
                } else {
                    return $this->dispatchBrowserEvent('toast', [
                        'type' => 'error',
                        'body' => 'Forbidden!',
                    ]);
                }
            } else {
                return $this->dispatchBrowserEvent('toast', [
                    'type' => 'error',
                    'body' => 'Forbidden!',
                ]);
            }
        } else {
            return Helper::toast($this, 'error', 'Forbidden!',
            ]);
        }
    }

    public function deleteWebhook($id)
    {
        if (auth()->check()) {
            if (auth()->user()->id === $this->user->id) {
                loggy(request(), 'User', auth()->user(), 'Deleted a webhook | Webhook ID: '.$id);
                $webhook = Webhook::find($id);
                $webhook->delete();
                $this->emit('refreshIntegrations');

                return $this->dispatchBrowserEvent('toast', [
                    'type' => 'success',
                    'body' => 'Webhook has been deleted!',
                ]);
            } else {
                return $this->dispatchBrowserEvent('toast', [
                    'type' => 'error',
                    'body' => 'Forbidden!',
                ]);
            }
        } else {
            return Helper::toast($this, 'error', 'Forbidden!',
            ]);
        }
    }

    public function render()
    {
        return view('livewire.user.settings.integrations');
    }
}
