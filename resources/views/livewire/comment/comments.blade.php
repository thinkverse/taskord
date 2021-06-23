<div wire:init="loadComments">
    @if (!$readyToLoad)
        <div class="mt-3">
            <x:loaders.reply-skeleton count="1" />
        </div>
        <div class="mt-3">
            <x:loaders.reply-skeleton count="1" />
        </div>
        <div class="mt-3 mb-3">
            <x:loaders.reply-skeleton count="1" />
        </div>
    @endif
    @if ($readyToLoad and count($comments) === 0)
        <div class="card-body text-center mt-3 mb-3">
            <x-heroicon-o-chat-alt-2 class="heroicon heroicon-60px text-primary mb-2" />
            <div class="h4">
                No comments found!
            </div>
        </div>
    @endif
    @foreach ($comments as $comment)
        <div class="mb-3 {{ $comment->first ?: 'mt-3' }}">
            <livewire:comment.single-comment :comment="$comment" :wire:key="$comment->id" />
        </div>
    @endforeach
    @if ($readyToLoad and $comments->hasMorePages())
        <livewire:comment.load-more :task="$task" :page="$page" :perPage="$perPage" />
    @endif
</div>
