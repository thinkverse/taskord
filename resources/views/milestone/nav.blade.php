<div class="mb-3">
    <a class="mb-2 btn btn-{{ Route::currentRouteName() === 'milestone.opened' ? '' : 'outline-' }}primary me-2" href="{{ route('questions.newest') }}">
        Opened
    </a>
    <a class="mb-2 btn btn-{{ Route::currentRouteName() === 'milestone.closed' ? '' : 'outline-' }}primary me-2" href="{{ route('questions.unanswered') }}">
        Closed
    </a>
    @auth
    <button type="button" class="mb-2 btn btn-success float-md-end text-white" data-bs-toggle="modal" data-bs-target="#newQuestionModal">
        <x-heroicon-o-plus class="heroicon" />
        Create a milestone
    </button>
    @livewire('milestone.create-milestone')
    @endauth
</div>
