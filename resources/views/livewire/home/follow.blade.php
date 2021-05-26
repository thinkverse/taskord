<div>
    @if (auth()->user()->isFollowing($user))
        <button wire:click="toggleFollow" wire:loading.attr="disabled" class="btn btn-sm btn-danger">
            <div wire:loading wire:target="toggleFollow" class="spinner-border spinner-border-sm me-1"></div>
            <x-heroicon-o-user-remove wire:loading.remove wire:target="toggleFollow" class="heroicon" />
            {{ $showText ? 'Unfollow' : '' }}
        </button>
    @else
        <button wire:click="toggleFollow" wire:loading.attr="disabled" class="btn btn-sm btn-primary">
            <div wire:loading wire:target="toggleFollow" class="spinner-border spinner-border-sm me-1"></div>
            <x-heroicon-o-user-add wire:loading.remove wire:target="toggleFollow" class="heroicon" />
            {{ $showText ? 'Follow' : '' }}
        </button>
    @endif
</div>
