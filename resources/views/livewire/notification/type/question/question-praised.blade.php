<div>
    <span>
        praised your
        <a class="fw-bold" href="{{ route('question.question', ['id' => $question->id]) }}">
            question
        </a>
    </span>
    <div class="mt-2 body-font">
        {{ $question->title }}
    </div>
</div>
