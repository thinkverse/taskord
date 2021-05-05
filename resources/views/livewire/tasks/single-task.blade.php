<li class="list-group-item pt-2 pb-2">
    <div class="form-check">
        <input
            class="form-check-input task-check"
            id="task-{{ $task->id }}"
            type="checkbox"
            wire:click="checkTask"
            unchecked
        />
        <label for="task-{{ $task->id }}" class="task-font text-dark ms-2">
            {!! Purify::clean(Helper::renderTask($task->task)) !!}
            @if ($task->type === 'product')
            <span class="small text-secondary">
                <img loading=lazy class="rounded mb-1 ms-1 avatar-15" src="{{ Helper::getCDNImage($task->product->avatar, 80) }}" height="15" width="15" alt="{{ $task->product->slug }}'s avatar" />
                <a class="text-secondary" href="{{ route('product.done', ['slug' => $task->product->slug]) }}">
                    {{ $task->product->name }}
                </a>
            </span>
            @endif
        </label>
    </div>
    @if ($task->images)
    <div class="gallery mb-3">
    @foreach ($task->images ?? [] as $image)
    <div>
        <a href="{{ asset('storage/' . $image) }}" target="_blank">
            <img loading=lazy class="gallery img-fluid border mt-3 rounded" src="{{ Helper::getCDNImage(asset('storage/' . $image), 500) }}" alt="{{ asset('storage/' . $image) }}" />
        </a>
    </div>
    @endforeach
    </div>
    @endif
    @if ($task->milestone)
    <div class="my-1" title="Milestone">
        <a class="text-secondary" href="{{ route('milestones.milestone', ['id' => $task->milestone->id]) }}">
            <x-heroicon-o-truck class="heroicon me-1" />
            <span>{{ $task->milestone->name }}</span>
        </a>
    </div>
    @endif
    <div class="mt-1">
        <div class="fw-bold me-2 mb-1 small">
            @if ($task->due_at)
                {!! Helper::renderDueDate($task->due_at) !!}
            @endif
        </div>
        @if (auth()->user()->id === $task->user->id)
            @livewire('task.select-milestone', [
                'task' => $task
            ])
            @if ($confirming === $task->id)
            <button type="button" class="btn btn-task btn-danger my-1" wire:click="deleteTask" wire:loading.attr="disabled" aria-label="Confirm Delete">
                Are you sure?
            </button>
            @else
            <button type="button" class="btn btn-task btn-outline-danger my-1" wire:click="confirmDelete" wire:loading.attr="disabled" aria-label="Delete">
                <x-heroicon-o-trash class="heroicon-small me-0 text-secondary" />
            </button>
            @endif
        @endif
    </div>
</li>
