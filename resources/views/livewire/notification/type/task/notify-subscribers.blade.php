<div>
    @if ($comment)
    <div class="mt-2 text-secondary">
        commented on a
        <a class="fw-bold" href="{{ route('task', ['id' => $comment->task->id]) }}">
            task
        </a>
        you subscribed
        @if ($comment->hidden)
        <div class="body-font fst-italic text-secondary mt-2">Comment was hidden by moderator</div>
        @else
            <div class="mt-2 body-font">{!! markdown($comment->comment) !!}</div>
        @endif
    </div>
    @else
    <div class="body-font fst-italic text-secondary mt-2">Notification source was deleted</div>
    @endif
</div>
