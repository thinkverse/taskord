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

    public function updatedAvatar()
    {
        $this->validate([
            'avatar' => ['nullable', 'mimes:jpeg,jpg,png,gif', 'max:1024'],
        ]);
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

    public function deleteProduct()
    {
        if (Gate::denies('edit/delete', $this->product)) {
            return toast($this, 'error', config('taskord.error.deny'));
        }

        loggy(request(), 'Product', auth()->user(), "Deleted a product | Product Slug: #{$this->product->slug}");
        $avatar = explode('storage/', $this->product->avatar);
        if (array_key_exists(1, $avatar)) {
            Storage::delete($avatar[1]);
        }
        $this->product->tasks()->delete();
        $this->product->webhooks()->delete();
        $this->product->delete();
        auth()->user()->touch();

        return redirect()->route('products.newest');
    }
}
