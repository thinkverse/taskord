<?php

namespace App\Http\Livewire;

use App\Actions\CreateNewTask;
use App\Jobs\CheckGoal;
use GrahamCampbell\Throttle\Facades\Throttle;
use Helper;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Livewire\Component;
use Livewire\WithFileUploads;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;

class CreateTask extends Component
{
    use WithFileUploads;
    use WithRateLimiting;

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
            return toast($this, 'error', config('taskord.error.deny'));
        }

        auth()->user()->check_state = ! auth()->user()->check_state;

        return auth()->user()->save();
    }

    public function updatedImage()
    {
        if (! auth()->check()) {
            return toast($this, 'error', config('taskord.error.deny'));
        }

        $this->validate([
            'images' => ['max:5'],
            'images.*' => ['nullable', 'mimes:jpeg,jpg,png,gif', 'max:5000'],
        ]);
    }

    public function submit()
    {
        try {
            $this->rateLimit(10);
        } catch (TooManyRequestsException $exception) {
            return toast($this, 'error', config('taskord.error.rate-limit'));
        }
        
        if (Gate::denies('create')) {
            return toast($this, 'error', config('taskord.error.deny'));
        }

        $this->validate([
            'task' => ['required', 'min:5', 'max:10000'],
            'images' => ['max:5'],
            'images.*' => ['nullable', 'mimes:jpeg,jpg,png,gif', 'max:5000'],
        ]);

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
