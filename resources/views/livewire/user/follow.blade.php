<div>
    @auth
        @can('user.follow', $user)
            @if (auth()->user()->isFollowing($user))
                <button wire:click="toggleFollow" wire:loading.attr="disabled" class="btn btn-sm btn-danger mb-2">
                    <x-heroicon-o-user-remove class="heroicon" />
                    Unfollow
                </button>
            @else
                <button wire:click="toggleFollow" wire:loading.attr="disabled" class="btn btn-sm btn-primary mb-2">
                    <x-heroicon-o-user-add class="heroicon" />
                    Follow
                </button>
            @endif
        @endcan
    @endauth
    <div class="small">
        <a class="text-dark" href="{{ route('user.following', ['username' => $user->username]) }}">
            <span class="fw-bold">{{ $user->followings->count('id') }}</span>
            {{ pluralize('Following', $user->followings->count('id')) }}
        </a>
        <a class="text-dark" href="{{ route('user.followers', ['username' => $user->username]) }}">
            <span class="fw-bold ms-2">{{ number_format($user->followers->count()) }}</span>
            {{ pluralize('Follower', $user->followers->count('id')) }}
        </a>
    </div>
</div>
