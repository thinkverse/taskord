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

        dd($records);

        auth()->user()->touch();

        loggy(request(), 'Product', auth()->user(), "Verified the product domain | Product ID: {$this->product->id}");

        return redirect()->route('product.done', ['slug' => $product->slug]);
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
