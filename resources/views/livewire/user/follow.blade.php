<div>
    @can('user.follow', $user)
        <div
            x-data="{isFollowing: '{{ auth()->user()->isFollowing($user) }}'}"
        >
            <button
                x-cloak
                x-on:click="isFollowing = ! isFollowing"
                wire:click="toggleFollow"
                class="btn btn-sm rounded-pill mb-2"
                x-bind:class="{ 'btn-outline-danger': isFollowing, 'btn-outline-success':  ! isFollowing }"
            >
                <x-heroicon-o-user-remove class="heroicon heroicon-15px" />
                <span x-show="isFollowing">
                    Unfollow
                </span>
                <span x-show="!isFollowing">
                    Follow
                </span>
            </button>
        </div>
    @endcan
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
