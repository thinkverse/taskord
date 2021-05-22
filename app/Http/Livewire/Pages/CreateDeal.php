<?php

namespace App\Http\Livewire\Pages;

use App\Models\Deal;
use Helper;
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
                loggy(request(), 'Admin', auth()->user(), 'Created a new deal | Deal ID: '.$deal->id);

                return redirect()->route('deals');
            } else {
                 toast($this, 'error', 'Forbidden!');
            }
        } else {
            Helper::toast($this, 'error', 'Forbidden!');
        }
    }
}
