<?php

namespace App\Http\Livewire\User\Settings;

use App\Models\Webhook;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Integrations extends Component
{
    public $user;
    public $name;

    public function mount($user)
    {
        $this->user = $user;
    }

    public function submit()
    {
        if (Auth::check()) {
            if (Auth::id() === $this->user->id) {
                $webhook = Webhook::create([
                    'user_id' => Auth::id(),
                    'name' => $this->name,
                    'token' => md5(Auth::id().Carbon::now()),
                    'type' => 'web',
                ]);
                session()->flash('created', $webhook);
            } else {
                return session()->flash('error', 'Forbidden!');
            }
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function render()
    {
        return view('livewire.user.settings.integrations');
    }
}
