<?php

namespace App\Http\Livewire\Product;

use App\Models\Product;
use App\Rules\Repo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Jobs\CreateTaskOnLaunch;

class NewProduct extends Component
{
    use WithFileUploads;

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

    public function updatedAvatar()
    {
        if (Auth::check()) {
            $this->validate([
                'avatar' => 'nullable|mimes:jpeg,jpg,png,gif|max:1024',
            ]);
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }

    public function submit()
    {
        if (Auth::check()) {
            $this->validate([
                'name' => 'required|max:30',
                'slug' => 'required|min:3|max:20|unique:products|alpha_dash',
                'description' => 'nullable|max:160',
                'website' => 'nullable|active_url',
                'twitter' => 'nullable|alpha_dash|max:30',
                'repo' => ['nullable', 'active_url', new Repo],
                'producthunt' => 'nullable|alpha_dash|max:30',
                'sponsor' => 'nullable|active_url',
                'avatar' => 'nullable|mimes:jpeg,jpg,png,gif|max:1024',
            ]);

            if (! user()->hasVerifiedEmail()) {
                return $this->alert('warning', 'Your email is not verified!');
            }

            if (user()->isFlagged) {
                return $this->alert('error', 'Your account is flagged!');
            }

            $launched = ! $this->launched ? false : true;

            if ($launched) {
                $launched_status = true;
                $launched_at = carbon();
            } else {
                $launched_status = false;
                $launched_at = null;
            }

            if ($this->avatar) {
                $img = Image::make($this->avatar)
                        ->fit(400)
                        ->encode('webp', 80);
                $imageName = Str::random(32).'.png';
                Storage::disk('public')->put('logos/'.$imageName, (string) $img);
                $url = config('app.url').'/storage/logos/'.$imageName;
            } else {
                $url = 'https://avatar.tobi.sh/'.md5($this->slug).'.svg?text=📦';
            }

            $product = Product::create([
                'user_id' =>  user()->id,
                'name' => $this->name,
                'slug' => $this->slug,
                'avatar' => $url,
                'description' => $this->description,
                'website' => $this->website,
                'twitter' => $this->twitter,
                'repo' => $this->repo,
                'producthunt' => $this->producthunt,
                'sponsor' => $this->sponsor,
                'launched' => $launched_status,
                'launched_at' => $launched_at,
            ]);

            if ($launched_status) {
                CreateTaskOnLaunch::dispatch($product);
            }

            user()->touch();

            activity()
                ->withProperties(['type' => 'Product'])
                ->log('Created a new product | Product Slug: #'.$product->slug);

            $this->flash('success', 'Product has been created!');

            return redirect()->route('product.done', ['slug' => $product->slug]);
        } else {
            $this->alert('error', 'Forbidden!');
        }
    }
}
