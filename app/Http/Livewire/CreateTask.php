<?php

namespace App\Http\Livewire;

use App\Actions\CreateNewTask;
use App\Jobs\CheckGoal;
use GrahamCampbell\Throttle\Facades\Throttle;
use Helper;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateTask extends Component
{
    use WithFileUploads;

    public $task;
    public $images = [];
    public $dueAt;
    public $product;
    public $showLatestTask = false;
    public $latestTask;

    public function mount($product = null)
    {
        $this->product = $product;
    }

    public function checkState()
    {
        if (! auth()->check()) {
            return toast($this, 'error', 'Forbidden!');
        }

        auth()->user()->check_state = ! auth()->user()->check_state;
        auth()->user()->save();
    }

    public function updatedImage()
    {
        if (! auth()->check()) {
            return toast($this, 'error', 'Forbidden!');
        }

        $this->validate([
            'images' => ['max:5'],
            'images.*' => ['nullable', 'mimes:jpeg,jpg,png,gif', 'max:5000'],
        ]);
    }

    public function submit()
    {
        $throttler = Throttle::get(Request::instance(), 20, 5);
        $throttler->hit();
        if (count($throttler) > 30) {
            Helper::flagAccount(auth()->user());
        }
        if (! $throttler->check()) {
            loggy(request(), 'Throttle', auth()->user(), 'Rate limited while creating a task');

            return toast($this, 'error', 'Your are rate limited, try again later!');
        }

        if (! auth()->check()) {
            return toast($this, 'error', 'Forbidden!');
        }

        $this->validate([
            'task' => ['required', 'min:5', 'max:10000'],
            'images' => ['max:5'],
            'images.*' => ['nullable', 'mimes:jpeg,jpg,png,gif', 'max:5000'],
        ]);

        if (! auth()->user()->hasVerifiedEmail()) {
            return toast($this, 'error', 'Your email is not verified!');
        }

        if (auth()->user()->spammy) {
            return toast($this, 'error', 'Your account is flagged!');
        }

        if ($this->images) {
            $images = [];
            foreach ($this->images as $image) {
                $img = Image::make($image)
                    ->encode('webp', 100);
                $imageName = Str::orderedUuid().'.webp';
                Storage::disk('public')->put('photos/'.$imageName, (string) $img);
                $image = 'photos/'.$imageName;
                array_push($images, $image);
            }
        } else {
            $images = null;
        }

        $state = auth()->user()->check_state;

        if ($state) {
            $done_at = carbon();
        } else {
            $done_at = null;
        }

        if (! $this->product) {
            $product_id = Helper::getProductIDFromMention($this->task, auth()->user());
        } else {
            $product_id = $this->product->id;
        }

        $task = (new CreateNewTask(auth()->user(), [
            'product_id' =>  $product_id,
            'task' => $this->task,
            'done' => $state,
            'done_at' => $done_at,
            'images' => $images,
            'due_at' => $this->dueAt,
            'type' => $product_id ? 'product' : 'user',
        ]))();

        $this->emit('refreshTasks');
        $this->reset(['task', 'images', 'dueAt']);
        if (auth()->user()->has_goal and $task->done) {
            auth()->user()->daily_goal_reached++;
            auth()->user()->save();
            CheckGoal::dispatch(auth()->user(), $task);
        }
        $this->latestTask = $task;

        return toast($this, 'success', 'Task has been created!');
    }
}
