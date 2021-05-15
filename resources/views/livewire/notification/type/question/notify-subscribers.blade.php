<div>
    @if ($answer and $answer->question)
        <div class="mt-2 text-secondary">
            answered to the
            <a class="fw-bold" href="{{ route('question.question', ['id' => $answer->question->id]) }}">
                question
            </a>
            you subscribed
            <div class="card mt-3">
                <livewire:answer.single-answer :answer="$answer" :wire:key="$answer->id" />
            </div>
        </div>
    @else
        <div class="body-font fst-italic text-secondary mt-2">Notification source was deleted</div>
    @endif
</div>
