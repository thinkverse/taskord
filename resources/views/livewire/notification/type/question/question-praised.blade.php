<div>
    <div>
        praised your
        <a class="fw-bold" href="{{ route('question.question', ['id' => $question->id]) }}">
            question
        </a>
    </div>
    <div class="mt-2 body-font">
        {{ $question->title }}
    </div>
</div>
