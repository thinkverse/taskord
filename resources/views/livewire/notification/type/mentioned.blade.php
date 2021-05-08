<div>
    @if ($data['body_type'] === 'task')
    <span class="align-middle">
        mentioned you in a
        <a class="fw-bold" href="{{ route('task', ['id' => $data['body_id']]) }}">
            task
        </a>
    </span>
    <div class="mt-2 body-font">
        {!! Purify::clean(Helper::renderTask($body->task)) !!}
    </div>
    @elseif ($data['body_type'] === 'comment')
    <span class="align-middle">
        mentioned you in a
        <a class="fw-bold" href="{{ route('comment', ['id' => $data['body_id'], 'comment_id' => $data['entity_id']]) }}">
            comment
        </a>
    </span>
    <div class="mt-2 body-font">
        {!! markdown($body->comment) !!}
    </div>
    @elseif ($data['body_type'] === 'answer')
    <span class="align-middle">
        mentioned you in an
        <a class="fw-bold" href="{{ route('question.question', ['id' => $data['body_id']]) }}">
            answer
        </a>
    </span>
    <div class="mt-2 body-font">
        {!! markdown($body->answer) !!}
    </div>
    @endif
</div>
