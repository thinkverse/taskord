<div wire:init="loadQuestions">
    @if (!$readyToLoad)
        <div>
            <x:loaders.question-big-skeleton count="1" />
        </div>
        <div class="mt-2">
            <x:loaders.question-big-skeleton count="1" />
        </div>
        <div class="mt-2">
            <x:loaders.question-big-skeleton count="1" />
        </div>
    @else
        @if (count($questions) === 0)
            <div class="card-body text-center mt-3 mb-3">
                <x-heroicon-o-question-mark-circle class="heroicon heroicon-60px text-primary mb-2" />
                <div class="h4">
                    No questions asked
                </div>
            </div>
        @endif
        @foreach ($questions as $question)
            @livewire('question.single-question', [
            'type' => $type,
            'question' => $question,
            ], key($question->id))
        @endforeach
        @if ($questions->hasMorePages())
            <livewire:question.load-more :type="$type" :page="$page" :perPage="$perPage" />
        @endif
    @endif
</div>
