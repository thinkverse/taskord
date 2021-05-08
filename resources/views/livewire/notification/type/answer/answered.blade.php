<div>
    <div>
        answered to your
        <a class="fw-bold" href="{{ route('question.question', ['id' => $answer->id]) }}">
            question
        </a>
    </div>
    <div class="mt-2 body-font">
        {!! markdown($answer->answer) !!}
    </div>
</div>
