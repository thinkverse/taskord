<div wire:init="loadPopularTasks">
    @if (!$readyToLoad)
    <div class="card-body text-center mt-3 mb-3">
        <div class="spinner-border taskord-spinner text-secondary mb-3" role="status"></div>
        <div class="h6">
            Loading popular tasks...
        </div>
    </div>
    @endif
    @foreach ($tasks as $task)
    <div class="card mb-3">
        <span class="p-3">
            @livewire('task.single-task', [
                'task' => $task,
            ], key($task->id))
        </span>
    </div>
    @endforeach
</div>
