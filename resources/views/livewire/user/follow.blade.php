<div>
    @auth
    @if (Auth::id() !== $user->id && !$user->isFlagged)
    @if (Auth::user()->isFollowing($user))
    <button wire:click="followUser" wire:loading.attr="disabled" class="btn btn-sm btn-danger mb-2">
        <i class="fa fa-user-minus me-1"></i>
        Unfollow
        <span wire:target="followUser" wire:loading class="spinner-border spinner-border-sm ms-2" role="status"></span>
    </button>
    @else
    <button wire:click="followUser" wire:loading.attr="disabled" class="btn btn-sm btn-primary mb-2">
        <i class="fa fa-user-plus me-1"></i>
        Follow
        <span wire:target="followUser" wire:loading class="spinner-border spinner-border-sm ms-2" role="status"></span>
    </button>
    @endif
    @if (session()->has('error'))
        <span class="ms-2 text-danger fw-bold">{{ session('error') }}</span>
    @endif
    @endif
    @endauth
    <div class="small">
        <a class="text-dark" href="{{ route('user.following', ['username' => $user->username]) }}">
            <span class="fw-bold">{{ $user->followings()->count('id') }}</span>
            Following
        </a>
        <a class="text-dark" href="{{ route('user.followers', ['username' => $user->username]) }}">
            <span class="fw-bold ms-2">{{ number_format($user->followers()->count()) }}</span>
            {{ $user->followers()->count('id') <= 1 ? "Follower" : "Followers" }}
        </a>
        @php
            $likes = $user->likes(App\Models\Task::class)->count('id') +
                $user->likes(App\Models\Comment::class)->count('id') +
                $user->likes(App\Models\Question::class)->count('id') +
                $user->likes(App\Models\Answer::class)->count('id')
        @endphp
        <span class="fw-bold ms-2">
            {{
                number_format(
                    $likes
                )
            }}
        </span>
        {{ $likes <= 1 ? "Praise" : "Praises" }}
    </div>
</div>
