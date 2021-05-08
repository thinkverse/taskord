<div>
    @if ($comment)
    <div class="mt-2">
        praised your
        <a class="fw-bold" href="{{ route('comment', ['id' => $comment->task->id, 'comment_id' => $comment->id]) }}">
            comment
        </a>
    </div>
    <div class="mt-2 body-font">
        {!! markdown($comment->comment) !!}
    </div>
    @else
    <div class="body-font fst-italic text-secondary mt-2">Notification source was deleted</div>
    @endif
</div>
