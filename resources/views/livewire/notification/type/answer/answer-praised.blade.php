<div>
    @if ($answer)
    <div class="mt-2">
        praised your
        <a class="fw-bold" href="{{ route('question.question', ['id' => $answer->question->id]) }}">
            answer
        </a>
    </div>
    <div class="mt-2 body-font">
        {!! markdown($answer->answer) !!}
    </div>
    @else
    <div class="body-font fst-italic text-secondary mt-2">Notification source was deleted</div>
    @endif
</div>
