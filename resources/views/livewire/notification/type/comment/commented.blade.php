<div>
    @if ($comment)
    <div class="mt-2 text-black-50">
        commented on your
        <a class="fw-bold" href="{{ route('comment', ['id' => $comment->task->id, 'comment_id' => $comment->id]) }}">
            task
        </a>
    </div>
    @if ($comment->hidden)
        <div class="body-font fst-italic text-secondary mt-2">Comment was hidden by moderator</div>
    @else
        <div class="mt-2 body-font">{!! markdown($comment->comment) !!}</div>
    @endif
    @else
    <div class="body-font fst-italic text-secondary mt-2">Notification source was deleted</div>
    @endif
</div>
