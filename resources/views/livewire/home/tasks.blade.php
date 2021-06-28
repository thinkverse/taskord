<div wire:init="loadTasks" wire:poll>
    @if (!$readyToLoad)
        <x:loaders.task-skeleton count="3" />
    @else
        @if (count($tasks) === 0)
            <div class="card-body text-center mt-3 mb-3">
                <x-heroicon-o-check-circle class="heroicon heroicon-60px text-primary mb-2" />
                <div class="h4">
                    Follow some users to see tasks!
                </div>
                <div class="text-secondary">
                    You can also follow some users displayed in the <b>"Who to follow"</b> in sidebar
                </div>
            </div>
        @endif
        @if ($page === 1)
            <ul class="list-group">
        @endif
        @foreach ($tasks as $task)
            <li class="list-group-item p-3 {{ ($loop->index == 0 and $page > 1) ? 'border-top-0 rounded-0' : '' }}">
                <livewire:task.single-task :task="$task" :wire:key="$task->id" />
            </li>
        @endforeach
        @if ($tasks->hasMorePages())
            <livewire:home.load-more :page="$page" />
        @endif
        @if ($page === 1)
            </ul>
        @endif
    @endif
</div>
