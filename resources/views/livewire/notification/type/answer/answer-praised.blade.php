<div>
    <div class="mt-2">
        praised your
        <a class="fw-bold" href="{{ route('question.question', ['id' => $answer->question->id]) }}">
            answer
        </a>
    </div>
    <div class="mt-2 body-font">
        {!! markdown($answer->answer) !!}
    </div>
</div>
