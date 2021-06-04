<div class="card mb-4">
    <div class="card-body">
        @error('comment')
            <div class="alert alert-danger alert-dismissible fade show mt-2">
                <button type="button" class="btn-close small" data-bs-dismiss="alert"></button>
                <x-heroicon-o-exclamation class="heroicon" />
                {{ $message }}
            </div>
        @enderror
        <div class="mb-2">
            <x:markdown-toolbar htmlFor="comment-box" />
            <textarea placeholder="Add a comment" id="comment-box" class="form-control mentionInput mt-3" rows="3" wire:model.lazy="comment"></textarea>
        </div>
        <div class="d-flex justify-content-between align-items-center">
            <a class="small fw-bold text-secondary" href="https://guides.github.com/features/mastering-markdown" target="_blank">
                <x-heroicon-o-pencil-alt class="heroicon" />
                Markdown is supported
                 <x:labels.beta />
            </a>
            <button wire:loading.attr="disabled" wire:target="submit" class="btn btn-sm btn-outline-primary rounded-pill" type="submit" wire:click="submit">
                <x-heroicon-o-plus class="heroicon heroicon-15px" />
                Add Comment
            </button>
        </div>
    </div>
</div>
