<div>
    <span class="align-middle">
                        praised your
        <a class="fw-bold" href="{{ route('question.question', ['id' => $answer->question->id]) }}">
            answer
        </a>
    </span>
    <div class="mt-2 body-font">
        {!! markdown($answer->answer) !!}
    </div>
</div>
