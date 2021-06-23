<div wire:init="loadPopularTasks">
    @if (!$readyToLoad)
        <div>
            <x:loaders.task-skeleton count="1" />
        </div>
        <div class="mt-3">
            <x:loaders.task-skeleton count="1" />
        </div>
        <div class="mt-3">
            <x:loaders.task-skeleton count="1" />
        </div>
    @endif
    @foreach ($tasks as $task)
        <div class="card mb-3">
            <span class="p-3">
                <livewire:task.single-task :task="$task" :wire:key="$task->id" />
            </span>
        </div>
    @endforeach
    @if ($readyToLoad)
        <div class="text-center">
            <img class="avatar-100 my-3" src="https://ik.imagekit.io/taskordimg/tada_UEF5fl7T3.png" loading=lazy />
            <h4>
                That's everything we found for you, for now.
            </h4>
            <p>
                Come back soon to see what we find next.
            </p>
        </div>
    @endif
</div>
