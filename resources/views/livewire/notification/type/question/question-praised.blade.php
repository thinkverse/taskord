<div>
    @if ($question)
    <div class="mt-2 text-black-50">
        praised your
        <a class="fw-bold" href="{{ route('question.question', ['id' => $question->id]) }}">
            question
        </a>
    </div>
    @if ($question->hidden)
    <div class="body-font fst-italic text-secondary mt-2">Question was hidden by moderator</div>
    @else
        <div class="mt-2 body-font">{{ $question->title }}</div>
    @endif
    @else
    <div class="body-font fst-italic text-secondary mt-2">Notification source was deleted</div>
    @endif
</div>
