<div class="card {{ $comment->replies()->count('id') > 0 ? '' : 'mt-3' }}">
    <div class="card-body">
        @error('reply')
            <div class="alert alert-danger alert-dismissible fade show mt-2">
                <button type="button" class="btn-close small" data-bs-dismiss="alert"></button>
                <x-heroicon-o-exclamation class="heroicon" />
                {{ $message }}
            </div>
        @enderror
        <markdown-toolbar for="comment-box">
            <md-bold>bold</md-bold>
            <md-header>header</md-header>
            <md-italic>italic</md-italic>
            <md-quote>quote</md-quote>
            <md-code>code</md-code>
            <md-link>link</md-link>
            <md-image>image</md-image>
            <md-unordered-list>unordered-list</md-unordered-list>
            <md-ordered-list>ordered-list</md-ordered-list>
            <md-task-list>task-list</md-task-list>
            <md-mention>mention</md-mention>
            <md-ref>ref</md-ref>
        </markdown-toolbar>
        <div class="mb-2">
            <textarea placeholder="Add a reply" id="comment-box" class="form-control mentionInput" rows="3" wire:model.defer="reply"></textarea>
        </div>
        <div class="d-flex justify-content-between align-items-center">
            <div class="small fw-bold text-secondary">
                <x-heroicon-o-pencil-alt class="heroicon" />
                Markdown is supported
                 <x:labels.beta />
            </div>
            <button wire:loading.attr="disabled" wire:target="submit" class="btn btn-sm btn-primary" type="submit" wire:click="submit">
                <x-heroicon-o-plus class="heroicon" />
                Add Reply
            </button>
        </div>
    </div>
</div>
