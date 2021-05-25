<div>
    @error('task')
        <div class="alert alert-danger alert-dismissible fade show mt-2">
            <button type="button" class="btn-close small" data-bs-dismiss="alert"></button>
            <x-heroicon-o-exclamation class="heroicon" />
            {{ $message }}
        </div>
    @enderror
    <form wire:submit.prevent="submit">
        <div class="input-group mb-3">
            <div class="input-group-text">
                <input
                    class="form-check-input task-check"
                    type="checkbox"
                    aria-label="Checkbox"
                    wire:click="checkState"
                    wire:offline.attr="disabled"
                    {{ auth()->check() && auth()->user()->check_state ? 'checked' : 'unchecked' }}
                >
            </div>
            <input type="text" class="form-control mentionInput" placeholder="Add a Task" wire:model.lazy="task" autocomplete="off" aria-label="Task Input" />
        </div>
        <div class="d-flex justify-content-between">
        <div class="form-file form-file-sm col-6 col-lg-3">
            <input class="form-control form-control-sm" wire:model="images" accept="image/*" type="file" aria-label="Upload Images" multiple>
        </div>
        @auth
            @if (!auth()->user()->check_state)
                <div class="ms-auto me-2 d-none d-sm-block">
                    <input class="form-control form-control-sm" wire:model.defer="dueAt" type="date" placeholder="Due date" min="{{ carbon('today')->format('Y-m-d') }}" />
                </div>
            @endif
        @endauth
        <button wire:offline.attr="disabled" class="btn btn-sm btn-primary d-flex align-items-center" type="submit">
            <div wire:loading class="spinner-border spinner-border-sm me-2"></div>
            <div>
                <x-heroicon-o-plus wire:loading.remove class="heroicon" />
                <span>Add Task</span>
            </div>
        </button>
        </div>
        <div wire:loading wire:target="images">
            <div class="spinner-border spinner-border-sm mt-4" role="status"></div>
        </div>
        @if ($images)
            <div class="gallery">
                @foreach ($images ?? [] as $image)
                    <div>
                        <img loading=lazy class="{{ count($images) === 1 ? 'w-50' : 'gallery' }} img-fluid mt-3 rounded" src="{{ $image->temporaryUrl() }}" />
                    </div>
                @endforeach
            </div>
        @endif
        @error('images.*')
            <div class="text-danger fw-bold mt-3">{{ $message }}</div>
        @enderror
    </form>
    @if ($showLatestTask and $latestTask)
        <div class="mt-3">
            @livewire('tasks.single-task', [
                'task' => $latestTask,
                'show_delete' => false
            ], key($latestTask->id))
        </div>
    @endif
</div>
