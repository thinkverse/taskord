<div>
    @auth
    @if (Auth::id() !== $user->id && !$user->isFlagged)
    @if (Auth::user()->isFollowing($user))
    <button wire:click="followUser" wire:loading.attr="disabled" class="btn btn-sm btn-danger mb-2">
        <i class="fa fa-user-minus mr-1"></i>
        Unfollow
        <span wire:target="followUser" wire:loading class="spinner-border spinner-border-sm ml-2" role="status"></span>
    </button>
    @else
    <button wire:click="followUser" wire:loading.attr="disabled" class="btn btn-sm btn-primary mb-2">
        <i class="fa fa-user-plus mr-1"></i>
        Follow
        <span wire:target="followUser" wire:loading class="spinner-border spinner-border-sm ml-2" role="status"></span>
    </button>
    @endif
    @if (session()->has('error'))
        <span class="ml-2 text-danger font-weight-bold">{{ session('error') }}</span>
    @endif
    @endif
    @endauth
    <div class="small">
        <a class="text-dark" href="{{ route('user.following', ['username' => $user->username]) }}">
            <span class="font-weight-bold">{{ $user->followings()->count() }}</span>
            Following
        </a>
        <a class="text-dark" href="{{ route('user.followers', ['username' => $user->username]) }}">
            <span class="font-weight-bold ml-2">{{ number_format($user->followers()->count()) }}</span>
            {{ $user->followers()->count() <= 1 ? "Follower" : "Followers" }}
        </a>
        <span class="font-weight-bold ml-2">
            {{
                number_format(
                    $user->likes()->where('likeable_type', '!=', 'App\Models\Product')->count('id')
                )
            }}
        </span>
        {{ $user->likes()->where('likeable_type', '!=', 'App\Models\Product')->count('id') <= 1 ? "Praise" : "Praises" }}
    </div>
</div>
