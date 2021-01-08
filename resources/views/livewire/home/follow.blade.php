<div>
    @if (auth()->user()->isFollowing($user))
    <button wire:click="followUser" wire:loading.attr="disabled" class="btn btn-sm btn-danger">
        <x-heroicon-o-user-remove class="heroicon" />
        Unfollow
    </button>
    @else
    <button wire:click="followUser" wire:loading.attr="disabled" class="btn btn-sm btn-primary">
        <x-heroicon-o-user-add class="heroicon" />
        Follow
    </button>
    @endif
</div>
