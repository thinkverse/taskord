<div>
    <div class="h5 mb-3 text-secondary d-flex align-content-center">
        <x-heroicon-o-question-mark-circle class="heroicon-2x" />
        <span class="ms-1">Create new question</span>
    </div>
    <div class="card">
        <form wire:target="submit" wire:submit.prevent="submit">
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Title</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" placeholder="Ask and discuss!" wire:model.defer="title">
                    @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Body</label>
                    <textarea class="form-control @error('body') is-invalid @enderror mentionInput" rows="6" placeholder="What's on your mind?" wire:model.defer="body"></textarea>
                    @error('body')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="small fw-bold text-secondary mt-3">
                        <x-heroicon-o-pencil-alt class="heroicon" />
                        Markdown is supported
                        <x-beta />
                    </div>
                </div>
                @auth
                @if (auth()->user()->isPatron)
                <div class="mb-3">
                    <div class="fw-bold mb-2">Patron only</div>
                    <input id="patronOnly" class="form-check-input" type="checkbox" wire:model.defer="patronOnly">
                    <label for="patronOnly" class="ms-1">This question will visible only for patrons</label>
                </div>
                @else
                <div class="mb-2">
                    <a class="text-primary" href="{{ route('patron.home') }}">
                        ❤ Support Taskord to post patron only questions!
                    </a>
                </div>
                @endif
                @endauth
                <button type="submit" class="btn btn-primary">
                    Post
                </button>
            </div>
        </form>
    </div>
</div>
