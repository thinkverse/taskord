<div class="card mb-4">
    <div class="card-body">
        @error('comment')
            <div class="alert alert-danger alert-dismissible fade show mt-2">
                <button type="button" class="btn-close small" data-bs-dismiss="alert"></button>
                <x-heroicon-o-exclamation class="heroicon" />
                {{ $message }}
            </div>
        @enderror
        <div x-data="{ tab: 'edit' }">
            <ul class="nav nav-tabs d-flex justify-content-between">
                <div class="d-flex">
                    <li class="nav-item">
                        <div class="cursor-pointer nav-link" :class="{ 'active': tab === 'edit' }" @click="tab = 'edit'">Edit</div>
                    </li>
                    <li class="nav-item">
                        <div class="cursor-pointer nav-link" :class="{ 'active': tab === 'preview' }" @click="tab = 'preview'">Preview</div>
                    </li>
                </div>
                <div>
                    <x:markdown-toolbar htmlFor="comment-box" />
                </div>
            </ul>
            <div class="mb-2">
                <textarea x-show="tab === 'edit'" placeholder="Add a comment" id="comment-box" class="form-control mentionInput mt-3" rows="3" wire:model.lazy="comment"></textarea>
                <div x-show="tab === 'preview'" class="mt-3">{!! markdown($comment) !!}</div>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <a class="small fw-bold text-secondary" href="https://guides.github.com/features/mastering-markdown" target="_blank">
                    <x-heroicon-o-pencil-alt class="heroicon" />
                    Markdown is supported
                    <x:labels.beta />
                </a>
                <button wire:loading.attr="disabled" wire:target="submit" class="btn btn-sm btn-outline-primary rounded-pill" type="submit" wire:click="submit" @click="tab = 'edit'">
                    <x-heroicon-o-plus class="heroicon heroicon-15px" />
                    Comment
                </button>
            </div>
        </div>
    </div>
</div>
