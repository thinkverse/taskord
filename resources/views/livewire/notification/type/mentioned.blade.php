<div>
    @if ($data['body_type'] === 'task')
    <div class="mt-2">
        mentioned you in a
        <a class="fw-bold" href="{{ route('task', ['id' => $body->id]) }}">
            task
        </a>
    </div>
    <div class="mt-2 body-font">
        {!! Purify::clean(Helper::renderTask($body->task)) !!}
    </div>
    @elseif ($data['body_type'] === 'comment')
    <div class="mt-2">
        mentioned you in a
        <a class="fw-bold" href="{{ route('comment', ['id' => $body->task->id, 'comment_id' => $body->id]) }}">
            comment
        </a>
    </div>
    <div class="mt-2 body-font">
        {!! markdown($body->comment) !!}
    </div>
    @elseif ($data['body_type'] === 'answer')
    <div class="mt-2">
        mentioned you in an
        <a class="fw-bold" href="{{ route('question.question', ['id' => $body->question->id]) }}">
            answer
        </a>
    </div>
    <div class="mt-2 body-font">
        {!! markdown($body->answer) !!}
    </div>
    @endif
</div>
