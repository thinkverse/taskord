<div>
    @if ($comment)
    <div class="mt-2">
        commented on a
        <a class="fw-bold" href="{{ route('task', ['id' => $comment->task->id]) }}">
            task
        </a>
        you subscribed
        <div class="mt-2 body-font">
            {!! markdown($comment->comment) !!}
        </div>
    </div>
    @else
    <div class="body-font fst-italic text-secondary mt-2">Notification source was deleted</div>
    @endif
</div>
