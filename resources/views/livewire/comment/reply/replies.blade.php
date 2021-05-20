<div class="{{ $comment->replies->count('id') > 0 ? 'mt-4' : '' }}">
    @foreach ($comment->replies as $reply)
        <div class="mt-3 ms-3">
            <livewire:comment.reply.single-reply :reply="$reply" :wire:key="$reply->id" />
        </div>
    @endforeach
</div>
