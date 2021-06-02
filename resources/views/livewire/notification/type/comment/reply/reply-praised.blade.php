<div>
    @if ($comment)
        <div class="mt-2 text-secondary">
            replied your
            <a class="fw-bold" href="{{ route('comment', ['id' => $reply->comment->task->id, 'comment_id' => $reply->comment->id]) }}">
                comment
            </a>
        </div>
        <div class="card mt-3">
            <div class="card-body body-font">
                {!! markdown($body->reply) !!}
            </div>
        </div>
    @else
        <div class="body-font fst-italic text-secondary mt-2">Notification source was deleted</div>
    @endif
</div>
