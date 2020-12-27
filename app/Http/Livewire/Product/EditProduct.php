<?php

namespace App\Http\Livewire\Product;

use App\Models\Product;
use App\Rules\Repo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Actions\CreateNewTask;

class EditProduct extends Component
{
    use WithFileUploads;

    public Product $product;
    public $name;
    public $slug;
    public $description;
    public $avatar;
    public $website;
    public $twitter;
    public $repo;
    public $producthunt;
    public $sponsor;
    public $launched;
    public $deprecated;
    public $confirming;

    public function mount($product)
    {
        $this->product = $product;
        $this->name = $product->name;
        $this->slug = $product->slug;
        $this->description = $product->description;
        $this->website = $product->website;
        $this->twitter = $product->twitter;
        $this->repo = $product->repo;
        $this->producthunt = $product->producthunt;
        $this->sponsor = $product->sponsor;
        $this->launched = $product->launched;
        $this->deprecated = $product->deprecated;
    }

    public function updatedAvatar()
    {
        if (Auth::check()) {
            $this->validate([
                'avatar' => 'nullable|mimes:jpeg,jpg,png,gif|max:1024',
            ]);
        } else {
            return $this->alert('error', 'Forbidden!', [
                'showCancelButton' =>  false,
            ]);
        }
    }

    public function submit()
    {
        if (Auth::check()) {
            $this->validate([
                'name' => 'required|max:30',
                'slug' => 'required|min:3|max:20|alpha_dash|unique:products,slug,'.$this->product->id,
                'description' => 'nullable|max:280',
                'website' => 'nullable|active_url',
                'twitter' => 'nullable|alpha_dash|max:30',
                'repo' => ['nullable', 'active_url', new Repo],
                'producthunt' => 'nullable|alpha_dash|max:30',
                'sponsor' => 'nullable|active_url',
                'avatar' => 'nullable|mimes:jpeg,jpg,png,gif|max:1024',
            ]);

            if (Auth::user()->isFlagged) {
                return $this->alert('error', 'Your account is flagged!', [
                    'showCancelButton' =>  false,
                ]);
            }

            $product = Product::where('id', $this->product->id)->firstOrFail();

            if ($this->avatar) {
                $old_avatar = explode('storage/', $this->product->avatar);
                if (array_key_exists(1, $old_avatar)) {
                    Storage::delete($old_avatar[1]);
                }
                $img = Image::make($this->avatar)
                        ->fit(400)
                        ->encode('webp', 80);
                $imageName = Str::random(32).'.png';
                Storage::disk('public')->put('logos/'.$imageName, (string) $img);
                $avatar = config('app.url').'/storage/logos/'.$imageName;
                $product->avatar = $avatar;
            }

            if (Auth::user()->staffShip or Auth::id() === $product->owner->id) {
                if ($this->launched and ! $product->launched) {
                    $product->launched_at = Carbon::now();
                    $newelyLaunched = true;
                }

                $product->name = $this->name;
                $product->slug = $this->slug;
                $product->description = $this->description;
                $product->website = $this->website;
                $product->twitter = $this->twitter;
                $product->repo = $this->repo;
                $product->producthunt = $this->producthunt;
                $product->sponsor = $this->sponsor;
                $product->launched = $this->launched;
                $product->deprecated = $this->deprecated;
                $product->save();

                if ($newelyLaunched) {
                    (new CreateNewTask)->fromProductLaunch($product);
                }

                Auth::user()->touch();

                $this->flash('success', 'Product has been updated!', [
                    'showCancelButton' =>  false,
                ]);
                activity()
                    ->withProperties(['type' => 'Product'])
                    ->log('Product has been updated P: #'.$this->product->slug);

                return redirect()->route('product.done', ['slug' => $product->slug]);
            } else {
                $this->alert('error', 'Forbidden!', [
                    'showCancelButton' =>  false,
                ]);
            }
        } else {
            $this->alert('error', 'Forbidden!', [
                'showCancelButton' =>  false,
            ]);
        }
    }

    public function confirmDelete()
    {
        $this->confirming = $this->product->id;
    }

    public function deleteProduct()
    {
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

            if (Auth::user()->staffShip or Auth::id() === $this->product->owner->id) {
                activity()
                    ->withProperties(['type' => 'Product'])
                    ->log('Product was deleted P: #'.$this->product->slug);
                $avatar = explode('storage/', $this->product->avatar);
                if (array_key_exists(1, $avatar)) {
                    Storage::delete($avatar[1]);
                }
                $this->product->tasks()->delete();
                $this->product->webhooks()->delete();
                $this->product->delete();
                Auth::user()->touch();
                $this->flash('success', 'Product has been deleted!', [
                    'showCancelButton' =>  false,
                ]);

                return redirect()->route('products.newest');
            } else {
                $this->alert('error', 'Forbidden!', [
                    'showCancelButton' =>  false,
                ]);
            }
        } else {
            return $this->alert('error', 'Forbidden!', [
                'showCancelButton' =>  false,
            ]);
        }
    }
}
