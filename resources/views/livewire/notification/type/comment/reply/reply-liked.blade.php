<div>
    @if ($reply)
        <div class="mt-2 text-secondary">
            liked your
            <a class="fw-bold"
                href="{{ route('comment', ['taskId' => $reply->comment->task->id, 'commentId' => $reply->comment->id]) }}">
                comment
            </a>
        </div>
        <div class="card mt-3">
            <div class="card-body body-font">
                {!! markdown($reply->reply) !!}
            </div>
        </div>
    @else
        <div class="body-font fst-italic text-secondary mt-2">Notification source was deleted</div>
    @endif
</div>
