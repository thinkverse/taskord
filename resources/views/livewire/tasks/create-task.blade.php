<div>
    <div class="card mb-3">
        <div class="card-body">
            <x-alert />
            @error('task')
                <div class="alert alert-danger alert-dismissible fade show mt-2">
                    <button type="button" class="btn-close small" data-bs-dismiss="alert"></button>
                    <i class="fa fa-exclamation-triangle me-1"></i>
                    {{ $message }}
                </div>
            @enderror
            <form wire:submit.prevent="submit">
                <div class="mb-3">
                    <input type="text" class="form-control mentionInput" placeholder="Add a Task" wire:model.lazy="task" autocomplete="off">
                </div>
                <div class="d-flex justify-content-between">
                <div class="form-file form-file-sm col-6 col-lg-3">
                    <input class="form-control form-control-sm" wire:model="images" accept="image/*" type="file" multiple>
                </div>
                <div class="ms-auto me-2 d-none d-sm-block">
                    <input class="form-control form-control-sm" wire:model.defer="due_at" type="date" placeholder="Due date" min="{{ Carbon::today()->format('Y-m-d') }}" />
                </div>
                <button wire:loading.attr="disabled" wire:offline.attr="disabled" class="btn btn-sm btn-primary" type="submit">
                    <i class="fa fa-plus me-1"></i>
                    Add Task
                    <span wire:target="submit" wire:loading class="spinner-border spinner-border-mini ms-2" role="status"></span>
                </button>
                </div>
                <div wire:loading wire:target="images">
                    <div class="spinner-border spinner-border-sm mt-4" role="status">
                      <span class="sr-only">Loading...</span>
                    </div>
                </div>
                @if ($images)
                    <div class="gallery">
                    @foreach ($images ?? [] as $image)
                    <div>
                        <img class="{{ count($images) === 1 ? 'w-50' : 'gallery' }} img-fluid border mt-3 rounded" src="{{ $image->temporaryUrl() }}" />
                    </div>
                    @endforeach
                    </div>
                @endif
                @error('images')
                <div class="text-danger fw-bold mt-3">{{ $message }}</div>
                @enderror
            </form>
        </div>
    </div>
</div>
