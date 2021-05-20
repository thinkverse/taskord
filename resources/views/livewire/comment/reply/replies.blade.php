<div>
    @foreach ($comment->replies as $reply)
        <div class="mt-3 ms-3">
            <livewire:comment.reply.single-reply :reply="$reply" :wire:key="$reply->id" />
        </div>
    @endforeach
</div>
