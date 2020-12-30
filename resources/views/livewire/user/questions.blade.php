<div wire:init="loadQuestions">
    @if (!$readyToLoad)
    <div class="card-body text-center mt-3 mb-3">
        <div class="spinner-border taskord-spinner text-secondary mb-3" role="status"></div>
        <div class="h6">
            Loading Questions...
        </div>
    </div>
    @endif
    @if ($readyToLoad and count($questions) === 0)
    <div class="card-body text-center mt-3 mb-3">
        <x-heroicon-o-question-mark-circle class="heroicon-4x text-primary mb-2" />
        <div class="h4">
            No questions asked
        </div>
    </div>
    @endif
    @foreach ($questions as $question)
        @livewire('question.single-question', [
            'type' => 'question.newest',
            'question' => $question,
        ], key($question->id))
    @endforeach

    {{ $readyToLoad ? $questions->links() : '' }}
</div>
