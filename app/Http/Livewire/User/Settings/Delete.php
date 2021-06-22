<?php

namespace App\Http\Livewire\User\Settings;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Delete extends Component
{
    public User $user;

    public function mount($user)
    {
        $this->user = $user;
    }

    public function resetAccount()
    {
        if (auth()->user()->id === $this->user->id) {
            loggy(request(), 'User', auth()->user(), 'Resetted the user account');
            $user = User::find($this->user->id);
            // Delete Task Images
            foreach ($user->tasks as $task) {
                $task->oembed->delete();
                foreach ($task->images ?? [] as $image) {
                    Storage::delete($image);
                }
            }
            // Delete Product Logos
            foreach ($user->ownedProducts as $product) {
                $product->tasks()->delete();
                $product->webhooks()->delete();
                $avatar = explode('storage/', $product->avatar);
                if (array_key_exists(1, $avatar)) {
                    Storage::delete($avatar[1]);
                }
            }
            // Delete User Avatar
            $avatar = explode('storage/', $user->avatar);
            if (array_key_exists(1, $avatar)) {
                Storage::delete($avatar[1]);
            }
            $user->tasks()->delete();
            $user->comments()->delete();
            $user->questions()->delete();
            $user->answers()->delete();
            $user->ownedProducts()->delete();
            $user->notifications()->delete();
            $user->likes()->delete();
            $this->emit('accountResetted');

            return redirect()->route('home');
        }

        return toast($this, 'error', config('taskord.toast.deny'));
    }

    public function deleteAccount()
    {
        if (auth()->user()->id === $this->user->id) {
            loggy(request(), 'User', auth()->user(), 'Deleted the user account');
            $user = User::find($this->user->id);
            // Delete Task Images
            foreach ($user->tasks as $task) {
                $task->oembed->delete();
                foreach ($task->images ?? [] as $image) {
                    Storage::delete($image);
                }
            }
            // Delete Product Logos
            foreach ($user->ownedProducts as $product) {
                $product->tasks()->delete();
                $product->webhooks()->delete();
                $avatar = explode('storage/', $product->avatar);
                if (array_key_exists(1, $avatar)) {
                    Storage::delete($avatar[1]);
                }
            }
            // Delete User Avatar
            $avatar = explode('storage/', $user->avatar);
            if (array_key_exists(1, $avatar)) {
                Storage::delete($avatar[1]);
            }
            $user->tasks()->delete();
            $user->comments()->delete();
            $user->questions()->delete();
            $user->answers()->delete();
            $user->ownedProducts()->delete();
            $user->notifications()->delete();
            $user->likes()->delete();
            $user->delete();
            $this->emit('accountDeleted');

            return redirect()->route('home');
        }

        return toast($this, 'error', config('taskord.toast.deny'));
    }
}
