<div>
    @if ($comment)
        <div class="mt-2 text-secondary">
            commented on a
            <a class="fw-bold" href="{{ route('task', ['id' => $comment->task->id]) }}">
                task
            </a>
            you subscribed
            <div class="mt-3">
                <livewire:comment.single-comment :comment="$comment" :wire:key="$comment->id" />
            </div>
        </div>
    @else
        <div class="body-font fst-italic text-secondary mt-2">Notification source was deleted</div>
    @endif
</div>
