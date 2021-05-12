<div>
    @if ($answer and $answer->question)
    <div class="mt-2 text-secondary">
        answered to the
        <a class="fw-bold" href="{{ route('question.question', ['id' => $answer->question->id]) }}">
            question
        </a>
        you subscribed
        @if ($answer->hidden)
        <div class="body-font fst-italic text-secondary mt-2">Answer was hidden by moderator</div>
        @else
            <div class="mt-2 body-font">{!! markdown($answer->answer) !!}</div>
        @endif
    </div>
    @else
    <div class="body-font fst-italic text-secondary mt-2">Notification source was deleted</div>
    @endif
</div>
