<div>
    @if (auth()->user()->isFollowing($user))
        <button wire:click="toggleFollow" wire:loading.attr="disabled" class="btn btn-sm btn-danger">
            <x-heroicon-o-user-remove class="heroicon" />
            {{ $showText ? 'Unfollow' : '' }}
        </button>
    @else
        <button wire:click="toggleFollow" wire:loading.attr="disabled" class="btn btn-sm btn-primary">
            <x-heroicon-o-user-add class="heroicon" />
            {{ $showText ? 'Follow' : '' }}
        </button>
    @endif
</div>
