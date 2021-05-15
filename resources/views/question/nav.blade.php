<div class="mb-3">
    <a class="mb-2 btn btn-{{ Route::currentRouteName() === 'questions.newest' ? '' : 'outline-' }}primary me-2" href="{{ route('questions.newest') }}">
        Newest
    </a>
    <a class="mb-2 btn btn-{{ Route::currentRouteName() === 'questions.unanswered' ? '' : 'outline-' }}primary me-2" href="{{ route('questions.unanswered') }}">
        Unanswered
    </a>
    <a class="mb-2 btn btn-{{ Route::currentRouteName() === 'questions.popular' ? '' : 'outline-' }}primary me-2" href="{{ route('questions.popular') }}">
        Popular
    </a>
    @auth
        <a href="{{ route('questions.new') }}" class="mb-2 btn btn-success float-md-end text-white">
            <x-heroicon-o-plus class="heroicon" />
            Ask a Question
        </a>
    @endauth
</div>
