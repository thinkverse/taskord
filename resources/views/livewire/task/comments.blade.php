<div wire:init="loadComments" class="pt-3">
    <div class="card">
        <div class="card-body">
            @if (!$readyToLoad)
                <div class="text-center">
                    <div class="spinner-border spinner-border-sm taskord-spinner text-secondary" role="status"></div>
                </div>
            @else
                @foreach ($comments as $comment)
                    <x:shared.user-label-small :user="$comment->user" />
                    <div class="d-flex align-items-center mt-2 {{ $loop->last ? '' : 'mb-3' }}">
                        <div class="card d-inline-block bg-light">
                            <div class="card-body px-2 py-1 body-font">
                                {!! markdown($comment->comment) !!}
                            </div>
                        </div>
                        @if ($comment->replies_count > 0)
                            <a class="text-secondary d-inline-flex align-items-center ms-2">
                                <x-heroicon-o-chat-alt-2 class="heroicon heroicon-15px me-0" />
                                <span class="ms-1">{{ $comment->replies_count }}</span>
                            </a>
                        @endif
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
