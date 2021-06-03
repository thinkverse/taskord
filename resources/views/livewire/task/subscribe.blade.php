<div>
    @auth
        @if (auth()->user()->hasSubscribed($task))
            <button wire:click="subscribeTask" wire:loading.attr="disabled" class="btn btn-sm btn-outline-danger rounded-pill">
                <x-heroicon-o-status-offline class="heroicon" />
                Unsubscribe
            </button>
        @else
            <button wire:click="subscribeTask" wire:loading.attr="disabled" class="btn btn-sm btn-outline-primary rounded-pill">
                <x-heroicon-o-status-online class="heroicon" />
                Subscribe
            </button>
        @endif
    @endauth
    <span class="small ms-2">
        <span class="fw-bold">{{ number_format($task->subscribersCount()) }}</span>
        {{ pluralize('Subscriber', $task->subscribersCount()) }}
    </span>
</div>
