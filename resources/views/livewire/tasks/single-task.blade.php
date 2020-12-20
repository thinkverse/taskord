<li class="list-group-item pt-2 pb-2">
    <x-alert />
    <div>
        <input
            class="form-check-input task-checkbox"
            id="task-{{ $task->id }}"
            type="checkbox"
            wire:click="checkTask"
            unchecked
        />
        <label for="task-{{ $task->id }}" class="ms-1 task-font d-inline">
            {!! Purify::clean(Helper::renderTask($task->task)) !!}
            @if ($task->type === 'product')
            <span class="small text-secondary">
                on
<<<<<<< HEAD
                <img loading=lazy class="rounded mb-1 ms-1 avatar-15" src="{{ Helper::getCDNImage($task->product->avatar, 50) }}" alt="{{ $task->product->slug }}'s avatar" />
=======
                <img loading=lazy class="rounded mb-1 ms-1 avatar-15" src="{{ Helper::getCDNImage($task->product->avatar, 80) }}" alt="{{ $task->product->slug }}'s avatar" />
>>>>>>> b18e0c01a7a50af04ce03ea488741e1ccafd70c7
                <a class="text-secondary" href="{{ route('product.done', ['slug' => $task->product->slug]) }}">
                    {{ $task->product->name }}
                </a>
            </span>
            @endif
        </label>
        @if ($task->images)
        <div class="gallery mb-3">
        @foreach ($task->images ?? [] as $image)
        <div>
<<<<<<< HEAD
            <a href="{{ asset('storage/' . $image) }}" data-lightbox="{{ $image }}" data-title="Image by {{ '@'.$task->user->username }}">
=======
            <a href="{{ asset('storage/' . $image) }}" target="_blank">
>>>>>>> b18e0c01a7a50af04ce03ea488741e1ccafd70c7
                <img loading=lazy class="{{ count($task->images) === 1 ? 'w-50' : 'gallery' }} img-fluid border mt-3 rounded" src="{{ Helper::getCDNImage(asset('storage/' . $image), 500) }}" alt="{{ asset('storage/' . $image) }}" />
            </a>
        </div>
        @endforeach
        </div>
        @endif
        <span class="d-flex small float-end ms-auto">
            <span class="fw-bold me-2">
                @if ($task->due_at)
                    {!! Helper::dueDate($task->due_at) !!}
                @endif
            </span>
            @if (Auth::id() === $task->user->id)
                @if ($confirming === $task->id)
                <button type="button" class="btn btn-task btn-danger" wire:click="deleteTask" wire:loading.attr="disabled">
                    Are you sure?
                    <span wire:target="deleteTask" wire:loading class="spinner-border spinner-border-mini ms-2" role="status"></span>
                </button>
                @else
                <button type="button" class="btn btn-task btn-outline-danger" wire:click="confirmDelete" wire:loading.attr="disabled">
                    🗑
                </button>
                @endif
            @endif
        </span>
    </div>
</li>
