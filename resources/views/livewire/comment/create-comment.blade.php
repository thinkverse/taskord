<div class="card">
    <div class="card-body">
        @error('comment')
            <div class="alert alert-danger alert-dismissible fade show mt-2">
                <button type="button" class="btn-close small" data-bs-dismiss="alert"></button>
                <x-heroicon-o-exclamation class="heroicon" />
                {{ $message }}
            </div>
        @enderror
        <div class="mb-2">
            <markdown-toolbar for="comment-box">
                <md-bold><img src="/images/md/bold.svg" /></md-bold>
                <md-header><img src="/images/md/heading.svg" /></md-header>
                <md-italic><img src="/images/md/italic.svg" /></md-italic>
                <md-quote><img src="/images/md/quote.svg" /></md-quote>
                <md-code><img src="/images/md/code.svg" /></md-code>
                <md-link><img src="/images/md/link.svg" /></md-link>
                <md-image><img src="/images/md/image.svg" /></md-image>
                <md-unordered-list><img src="/images/md/list-unordered.svg" /></md-unordered-list>
                <md-ordered-list><img src="/images/md/list-ordered.svg" /></md-ordered-list>
                <md-task-list><img src="/images/md/tasklist.svg" /></md-task-list>
                <md-mention><img src="/images/md/mention.svg" /></md-mention>
            </markdown-toolbar>
            <textarea placeholder="Add a comment" id="comment-box" class="mt-2 form-control mentionInput" rows="3" wire:model.defer="comment"></textarea>
        </div>
        <div class="d-flex justify-content-between align-items-center">
            <div class="small fw-bold text-secondary">
                <x-heroicon-o-pencil-alt class="heroicon" />
                Markdown is supported
                 <x:labels.beta />
            </div>
            <button wire:loading.attr="disabled" wire:target="submit" class="btn btn-sm btn-primary" type="submit" wire:click="submit">
                <x-heroicon-o-plus class="heroicon" />
                Add Comment
            </button>
        </div>
    </div>
</div>
