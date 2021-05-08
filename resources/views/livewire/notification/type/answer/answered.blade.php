<div>
    <span>
        answered to your
        <a class="fw-bold" href="{{ route('question.question', ['id' => $answer->id]) }}">
            question
        </a>
    </span>
    <div class="mt-2 body-font">
        {!! markdown($answer->answer) !!}
    </div>
</div>
