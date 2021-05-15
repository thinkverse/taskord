<div>
    @if ($answer)
        <div class="mt-2 text-secondary">
            answered to your
            <a class="fw-bold" href="{{ route('question.question', ['id' => $answer->id]) }}">
                question
            </a>
        </div>
        <div class="card mt-3">
            <livewire:answer.single-answer :answer="$answer" :wire:key="$answer->id" />
        </div>
    @else
        <div class="body-font fst-italic text-secondary mt-2">Notification source was deleted</div>
    @endif
</div>
