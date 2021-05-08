<div>
    @if ($comment)
    <div>
        commented on your
        <a class="fw-bold" href="{{ route('comment', ['id' => $comment->task->id, 'comment_id' => $comment->id]) }}">
            task
        </a>
    </div>
    <div class="mt-2 body-font">
        @if ($comment->hidden)
            <span class="body-font fst-italic text-secondary">Comment was hidden by moderator</span>
        @else
            {!! markdown($comment->comment) !!}
        @endif
    </div>
    @else
    <div class="body-font fst-italic text-secondary">Notification source was deleted</div>
    @endif
</div>
