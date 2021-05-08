<div>
    <span class="align-middle">
        praised your
        <a class="fw-bold" href="{{ route('comment', ['id' => $comment->task->id, 'comment_id' => $comment->id]) }}">
            comment
        </a>
    </span>
    <div class="mt-2 body-font">
        {!! markdown($comment->comment) !!}
    </div>
</div>
