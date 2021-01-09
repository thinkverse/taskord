<div wire:init="loadPopularTasks">
    @if (!$readyToLoad)
    <div class="card-body text-center mt-3 mb-3">
        <div class="spinner-border taskord-spinner text-secondary mb-3" role="status"></div>
        <div class="h6">
            Loading popular tasks...
        </div>
    </div>
    @endif
    @if ($readyToLoad and count($tasks) === 0)
    <div class="card-body text-center mt-3 mb-3">
        <x-heroicon-o-check-circle class="heroicon-4x text-primary mb-2" />
        <div class="h4">
            Follow some users to see tasks!
        </div>
        <div class="text-secondary">
            You can also follow some users displayed in the <b>"Who to follow"</b> in sidebar
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
