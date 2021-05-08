<div>
    @if ($question)
    <div class="mt-2">
        praised your
        <a class="fw-bold" href="{{ route('question.question', ['id' => $question->id]) }}">
            question
        </a>
    </div>
    <div class="mt-2 body-font">
        {{ $question->title }}
    </div>
    @else
    <div class="body-font fst-italic text-secondary mt-2">Notification source was deleted</div>
    @endif
</div>
