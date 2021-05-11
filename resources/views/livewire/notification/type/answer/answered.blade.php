<div>
    @if ($answer)
    <div class="mt-2 text-black-50">
        answered to your
        <a class="fw-bold" href="{{ route('question.question', ['id' => $answer->id]) }}">
            question
        </a>
    </div>
    @if ($answer->hidden)
        <div class="body-font fst-italic text-secondary mt-2">Answer was hidden by moderator</div>
    @else
        <div class="mt-2 body-font">{!! markdown($answer->answer) !!}</div>
    @endif
    @else
    <div class="body-font fst-italic text-secondary mt-2">Notification source was deleted</div>
    @endif
</div>
