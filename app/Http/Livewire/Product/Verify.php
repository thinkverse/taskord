<?php

namespace App\Http\Livewire\Product;

use App\Actions\CreateNewTask;
use App\Models\Product;
use App\Rules\Repo;
use App\Rules\ReservedSlug;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Livewire\Component;
use Livewire\WithFileUploads;

class Verify extends Component
{
    use WithFileUploads;

    public Product $product;

    public function mount($product)
    {
        $this->product = $product;
    }

    public function submit()
    {
        if (Gate::denies('edit/delete', $this->product)) {
            return toast($this, 'error', config('taskord.error.deny'));
        }

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
            $this->product->txt_code = Str::uuid();
            $this->product->save();
        }

        $domain = $this->getDomain($this->product->website);
        $txtRecord = "_taskord-challenge-{$this->product->slug}.{$domain}";

        return view('livewire.product.verify', [
            'txt_record' => $txtRecord,
            'txt_code' => $this->product->txt_code,
        ]);
    }
}
