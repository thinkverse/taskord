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
                    <div class="mt-2 card d-inline-block bg-light {{ $loop->last ? '' : 'mb-3' }}">
                        <div class="card-body px-2 py-1 body-font">
                            {!! markdown($comment->comment) !!}
                        </div>
                    </div>
                    @if ($comment->replies_count > 0)
                        <span class="text-secondary d-inline-flex align-items-center">
                            <x-heroicon-o-chat-alt-2 class="heroicon heroicon-15px me-0" />
                            <span class="ms-1">{{ $comment->replies_count }}</span>
                        </span>
                    @endif
                @endforeach
            @endif
        </div>
    </div>
</div>
