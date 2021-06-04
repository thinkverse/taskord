<?php

namespace App\Http\Livewire\Product;

use App\Models\Product;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\Dns\Dns;

class Verify extends Component
{
    use WithFileUploads;

    public Product $product;

    public function mount($product)
    {
        $this->product = $product;
    }

    public function verifyDomain()
    {
        if (Gate::denies('edit/delete', $this->product)) {
            return toast($this, 'error', config('taskord.error.deny'));
        }

        $dns = new Dns();
        $records = $dns->getRecords($this->getDomain($this->product->website), 'TXT');
        $txtList = [];
        foreach ($records as $record) {
            array_push($txtList, $record->txt());
        }

        if (in_array($this->product->txt_code, $txtList)) {
            auth()->user()->touch();
            $this->product->verified_at = carbon();
            $this->product->save();
            loggy(request(), 'Product', auth()->user(), "Verified the product and domain | Product ID: {$this->product->id}");

            return toast($this, 'success', "Domain and product has been successfully verified 🎉");
        } else {
            return toast($this, 'error', "We can't verify the domain at this time, please try again later!");
        }
    }

    public function getDomain($url)
    {
        $pieces = parse_url($url);
        $domain = isset($pieces['host']) ? $pieces['host'] : $pieces['path'];
        if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
            return $regs['domain'];
        }

        return false;
    }

    public function render()
    {
        if (! $this->product->txt_code) {
            $this->product->txt_code = "_taskord-challenge-{$this->product->slug}-".Str::uuid();
            $this->product->save();
        }

        $txtRecord = $this->getDomain($this->product->website);

        return view('livewire.product.verify', [
            'txt_record' => $txtRecord,
            'txt_code' => $this->product->txt_code,
        ]);
    }
}
