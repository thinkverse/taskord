<?php

namespace App\Http\Livewire\Pages;

use App\Models\Deal;
use Livewire\Component;

class CreateDeal extends Component
{
    public $name;
    public $description;
    public $offer;
    public $coupon;
    public $website;
    public $logo;
    public $referral;

    public function submit()
    {
        if (auth()->check()) {
            $this->validate([
                'name' => ['required', 'min:2'],
                'description' => ['required', 'min:5'],
                'offer' => ['required', 'integer', 'max:100'],
                'coupon' => ['nullable'],
                'referral' => ['nullable', 'active_url'],
                'website' => ['required', 'active_url'],
                'logo' => ['required', 'active_url'],
            ]);
            if (auth()->user()->isStaff) {
                $deal = Deal::create([
                    'name' =>  $this->name,
                    'description' => $this->description,
                    'offer' => $this->offer,
                    'coupon' => $this->coupon,
                    'referral' => $this->referral,
                    'website' => $this->website,
                    'logo' => $this->logo,
                ]);
                auth()->user()->touch();
                $this->flash('success', 'Deal has been created!');
                loggy(request(), 'Admin', auth()->user(), 'Created a new deal | Deal ID: '.$deal->id);

                return redirect()->route('deals');
            } else {
                $this->dispatchBrowserEvent('toast', [
                    'type' => 'error',
                    'body' => 'Forbidden!'
                ]);
            }
        } else {
            $this->dispatchBrowserEvent('toast', [
                'type' => 'error',
                'body' => 'Forbidden!'
            ]);
        }
    }
}
