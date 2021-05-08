<div>
    @if ($data['body_type'] === 'task')
    <span>
        mentioned you in a
        <a class="fw-bold" href="{{ route('task', ['id' => $body->id]) }}">
            task
        </a>
    </span>
    <div class="mt-2 body-font">
        {!! Purify::clean(Helper::renderTask($body->task)) !!}
    </div>
    @elseif ($data['body_type'] === 'comment')
    <span>
        mentioned you in a
        <a class="fw-bold" href="{{ route('comment', ['id' => $body->task->id, 'comment_id' => $body->id]) }}">
            comment
        </a>
    </span>
    <div class="mt-2 body-font">
        {!! markdown($body->comment) !!}
    </div>
    @elseif ($data['body_type'] === 'answer')
    <span>
        mentioned you in an
        <a class="fw-bold" href="{{ route('question.question', ['id' => $body->question->id]) }}">
            answer
        </a>
    </span>
    <div class="mt-2 body-font">
        {!! markdown($body->answer) !!}
    </div>
    @endif
</div>
