<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use App\Notifications\Staff\ContributorEnabled;
use App\Notifications\Staff\PatronGifted;
use App\Notifications\Staff\UserVerified;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Illuminate\Support\Facades\Gate;

class Moderator extends Component
{
    public User $user;
    public $isBeta;
    public $isStaff;
    public $isPatron;
    public $darkMode;
    public $isContributor;
    public $isPrivate;
    public $isVerified;
    public $spammy;
    public $isSuspended;
    public $staffNotes;
    public $readyToLoad = false;

    public function mount($user)
    {
        $this->user = $user;
        $this->isBeta = $user->is_beta;
        $this->isStaff = $user->is_staff;
        $this->isPatron = $user->is_patron;
        $this->darkMode = $user->dark_mode;
        $this->isContributor = $user->is_contributor;
        $this->isPrivate = $user->is_private;
        $this->isVerified = $user->is_verified;
        $this->spammy = $user->spammy;
        $this->isSuspended = $user->is_suspended;
        $this->staffNotes = $user->staff_notes;
    }

    public function loadModerator()
    {
        $this->readyToLoad = true;
    }

    public function enrollBeta()
    {
        if (Gate::allows('staff_mode')) {
            $this->user->is_beta = ! $this->user->is_beta;
            $this->user->timestamps = false;
            $this->user->save();
            if ($this->user->is_beta) {
                return loggy(
                    request(),
                    'Staff',
                    auth()->user(),
                    'Enrolled to Beta | Username: @'.$this->user->username
                );
            }

            return loggy(
                request(),
                'Staff',
                auth()->user(),
                'Un-enrolled from Beta | Username: @'.$this->user->username
            );
        }

        return toast($this, 'error', 'Forbidden!');
    }

    public function enrollStaff()
    {
        if (Gate::allows('staff_mode')) {
            if ($this->user->id === 1) {
                return toast($this, 'error', 'Forbidden!');
            }
            $this->user->is_staff = ! $this->user->is_staff;
            $this->user->timestamps = false;
            $this->user->save();
            if ($this->user->is_staff) {
                return loggy(
                    request(),
                    'Staff',
                    auth()->user(),
                    'Enrolled as Staff | Username: @'.$this->user->username
                );
            }

            return loggy(
                request(),
                'Staff',
                auth()->user(),
                'Un-enrolled from Staff | Username: @'.$this->user->username
            );
        }

        return toast($this, 'error', 'Forbidden!');
    }

    public function enrollDeveloper()
    {
        if (Gate::allows('staff_mode')) {
            $this->user->is_contributor = ! $this->user->is_contributor;
            $this->user->timestamps = false;
            $this->user->save();
            if ($this->user->is_contributor) {
                $this->user->notify(new ContributorEnabled(true));

                return loggy(
                    request(),
                    'Staff',
                    auth()->user(),
                    'Enrolled as Contributor | Username: @'.$this->user->username
                );
            }

            return loggy(
                request(),
                'Staff',
                auth()->user(),
                'Un-enrolled from Contributor | Username: @'.$this->user->username
            );
        }

        return toast($this, 'error', 'Forbidden!');
    }

    public function privateUser()
    {
        if (Gate::allows('staff_mode')) {
            if ($this->user->id === 1) {
                return toast($this, 'error', 'Forbidden!');
            }
            $this->user->is_private = ! $this->user->is_private;
            $this->user->timestamps = false;
            $this->user->save();
            if ($this->user->is_private) {
                loggy(
                    request(),
                    'Staff',
                    auth()->user(),
                    'Enrolled as private user | Username: @'.$this->user->username
                );
            }

            return loggy(
                request(),
                'Staff',
                auth()->user(),
                'Un-enrolled from private user | Username: @'.$this->user->username
            );
        }

        return toast($this, 'error', 'Forbidden!');
    }

    public function flagUser()
    {
        if (Gate::allows('staff_mode')) {
            if ($this->user->id === 1) {
                return toast($this, 'error', 'Forbidden!');
            }
            $this->user->spammy = ! $this->user->spammy;
            $this->user->timestamps = false;
            $this->user->save();
            if ($this->user->spammy) {
                return loggy(
                    request(),
                    'Staff',
                    auth()->user(),
                    'Flagged the user | Username: @'.$this->user->username
                );
            }

            return loggy(
                request(),
                'Staff',
                auth()->user(),
                'Un-flagged the user | Username: @'.$this->user->username
            );
        }

        return toast($this, 'error', 'Forbidden!');
    }

    public function suspendUser()
    {
        if (auth()->check() && auth()->user()->is_staff) {
            if ($this->user->id === 1) {
                return toast($this, 'error', 'Forbidden!');
            }
            $this->user->is_suspended = ! $this->user->is_suspended;
            if ($this->user->is_suspended) {
                $this->user->spammy = true;
                $this->spammy = true;
            } else {
                $this->user->spammy = false;
                $this->spammy = false;
            }
            $this->user->timestamps = false;
            $this->user->save();
            if ($this->user->is_suspended) {
                return loggy(
                    request(),
                    'Staff',
                    auth()->user(),
                    'Suspended the user | Username: @'.$this->user->username
                );
            }

            return loggy(
                request(),
                'Staff',
                auth()->user(),
                'Un-suspended the user | Username: @'.$this->user->username
            );
        }

        return toast($this, 'error', 'Forbidden!');
    }

    public function enrollPatron()
    {
        if (auth()->check() && auth()->user()->is_staff) {
            $this->user->is_patron = ! $this->user->is_patron;
            $this->user->timestamps = false;
            $this->user->save();
            if ($this->user->is_patron) {
                $this->user->notify(new PatronGifted(true));

                return loggy(
                    request(),
                    'Staff',
                    auth()->user(),
                    'Enrolled as Patron | Username: @'.$this->user->username
                );
            }

            return loggy(
                request(),
                'Staff',
                auth()->user(),
                'Un-enrolled from Patron | Username: @'.$this->user->username
            );
        }

        return toast($this, 'error', 'Forbidden!');
    }

    public function verifyUser()
    {
        if (auth()->check() && auth()->user()->is_staff) {
            $this->user->is_verified = ! $this->user->is_verified;
            $this->user->timestamps = false;
            $this->user->save();
            if ($this->user->is_verified) {
                $this->user->notify(new UserVerified(true));

                return loggy(
                    request(),
                    'Staff',
                    auth()->user(),
                    'Verified the user | Username: @'.$this->user->username
                );
            }

            return loggy(
                request(),
                'Staff',
                auth()->user(),
                'Un-verified the user | Username: @'.$this->user->username
            );
        }

        return toast($this, 'error', 'Forbidden!');
    }

    public function enrollDarkMode()
    {
        if (auth()->check() && auth()->user()->is_staff) {
            $this->user->dark_mode = ! $this->user->dark_mode;
            $this->user->timestamps = false;
            $this->user->save();
            if ($this->user->dark_mode) {
                return loggy(
                    request(),
                    'Staff',
                    auth()->user(),
                    'Enrolled to Dark mode | Username: @'.$this->user->username
                );
            }

            return loggy(
                request(),
                'Staff',
                auth()->user(),
                'Un-enrolled from Dark mode | Username: @'.$this->user->username
            );
        }

        return toast($this, 'error', 'Forbidden!');
    }

    public function masquerade()
    {
        if (auth()->check() && auth()->user()->is_staff) {
            if ($this->user->id === 1) {
                return toast($this, 'error', 'Forbidden!');
            }
            loggy(
                request(),
                'Staff',
                auth()->user(),
                'Masqueraded | Username: @'.$this->user->username
            );
            Auth::loginUsingId($this->user->id);

            return redirect()->route('home');
        }

        return toast($this, 'error', 'Forbidden!');
    }

    public function resetAvatar()
    {
        if (auth()->check() && auth()->user()->is_staff) {
            $user = User::find($this->user->id);
            $user->timestamps = false;
            $user->avatar = 'https://avatar.tobi.sh/'.Str::orderedUuid().'.svg?text='.strtoupper(substr($user->username, 0, 2));
            $user->save();
            loggy(
                request(),
                'Staff',
                auth()->user(),
                'Resetted avatar | Username: @'.$this->user->username
            );

            return redirect()->route('user.done', ['username' => $this->user->username]);
        }

        return toast($this, 'error', 'Forbidden!');
    }

    public function releaseUsername()
    {
        if (auth()->check() && auth()->user()->is_staff) {
            $user = User::find($this->user->id);
            $user->timestamps = false;
            $user->username = strtolower(Str::random(6));
            $user->save();
            loggy(
                request(),
                'Staff',
                auth()->user(),
                'Released the username | Username: @'.$user->username
            );

            return redirect()->route('user.done', ['username' => $user->username]);
        }

        return toast($this, 'error', 'Forbidden!');
    }

    public function deleteTasks()
    {
        if (auth()->check() && auth()->user()->is_staff) {
            $user = User::find($this->user->id);
            $user->timestamps = false;
            foreach ($user->tasks as $task) {
                foreach ($task->images ?? [] as $image) {
                    Storage::delete($image);
                }
            }
            $user->tasks()->delete();
            loggy(
                request(),
                'Staff',
                auth()->user(),
                'Deleted all tasks | Username: @'.$this->user->username
            );

            return redirect()->route('user.done', ['username' => $this->user->username]);
        }

        return toast($this, 'error', 'Forbidden!');
    }

    public function deleteComments()
    {
        if (auth()->check() && auth()->user()->is_staff) {
            $user = User::find($this->user->id);
            $user->timestamps = false;
            $user->comments()->delete();
            loggy(
                request(),
                'Staff',
                auth()->user(),
                'Deleted all comments | Username: @'.$this->user->username
            );

            return redirect()->route('user.done', ['username' => $this->user->username]);
        }

        return toast($this, 'error', 'Forbidden!');
    }

    public function deleteQuestions()
    {
        if (auth()->check() && auth()->user()->is_staff) {
            $user = User::find($this->user->id);
            $user->timestamps = false;
            $user->questions()->delete();
            loggy(
                request(),
                'Staff',
                auth()->user(),
                'Deleted all questions | Username: @'.$this->user->username
            );

            return redirect()->route('user.done', ['username' => $this->user->username]);
        }

        return toast($this, 'error', 'Forbidden!');
    }

    public function deleteAnswers()
    {
        if (auth()->check() && auth()->user()->is_staff) {
            $user = User::find($this->user->id);
            $user->timestamps = false;
            $user->answers()->delete();
            loggy(
                request(),
                'Staff',
                auth()->user(),
                'Deleted all answers | Username: @'.$this->user->username
            );

            return redirect()->route('user.done', ['username' => $this->user->username]);
        }

        return toast($this, 'error', 'Forbidden!');
    }

    public function deleteMilestones()
    {
        if (auth()->check() && auth()->user()->is_staff) {
            $user = User::find($this->user->id);
            $user->timestamps = false;
            $user->milestones()->delete();
            loggy(
                request(),
                'Staff',
                auth()->user(),
                'Deleted all milestones | Username: @'.$this->user->username
            );

            return redirect()->route('user.done', ['username' => $this->user->username]);
        }

        return toast($this, 'error', 'Forbidden!');
    }

    public function deleteProducts()
    {
        if (auth()->check() && auth()->user()->is_staff) {
            $user = User::find($this->user->id);
            $user->timestamps = false;
            foreach ($user->ownedProducts as $product) {
                $product->tasks()->delete();
                $product->webhooks()->delete();
                $avatar = explode('storage/', $product->avatar);
                if (array_key_exists(1, $avatar)) {
                    Storage::delete($avatar[1]);
                }
            }
            $user->ownedProducts()->delete();
            loggy(
                request(),
                'Staff',
                auth()->user(),
                'Deleted all products | Username: @'.$this->user->username
            );

            return redirect()->route('user.done', ['username' => $this->user->username]);
        }

        return toast($this, 'error', 'Forbidden!');
    }

    public function deleteUser()
    {
        if (auth()->check() && auth()->user()->is_staff) {
            if ($this->user->id === 1) {
                return toast($this, 'error', 'Forbidden!');
            }

            loggy(
                request(),
                'Staff',
                auth()->user(),
                'Deleted the user | Username: @'.$this->user->username
            );

            $user = User::find($this->user->id);
            // Delete Task Images
            foreach ($user->tasks as $task) {
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
            $user->likes()->delete();
            $user->notifications()->delete();
            $user->delete();

            return redirect()->route('home');
        }

        return toast($this, 'error', 'Forbidden!');
    }

    public function updateUserStaffNotes()
    {
        $this->user->staff_notes = $this->staffNotes;
        $this->user->save();

        loggy(
            request(),
            'Staff',
            auth()->user(),
            'Updated the staff notes for user: @'.$this->user->username
        );

        return toast($this, 'success', 'Note has been updated!');
    }

    public function render()
    {
        return view('livewire.user.moderator', [
            'user' => $this->readyToLoad ? $this->user : [],
        ]);
    }
}
