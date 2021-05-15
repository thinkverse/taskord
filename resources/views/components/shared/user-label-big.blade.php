<div class="d-flex align-items-center">
    <a
        href="{{ route('user.done', ['username' => $user->username]) }}"
        class="user-popover"
        data-id="{{ $user->id }}"
    >
        <img
            loading=lazy class="avatar-40 rounded-circle"
            src="{{ Helper::getCDNImage($user->avatar, 80) }}"
            height="40"
            width="40"
            alt="{{ $user->username }}'s avatar"
        />
    </a>
    <span class="ms-2">
        <a
            href="{{ route('user.done', ['username' => $user->username]) }}"
            class="fw-bold text-dark user-popover"
            data-id="{{ $user->id }}"
        >
            @if ($user->firstname or $user->lastname)
                {{ $user->firstname }}{{ ' '.$user->lastname }}
            @else
                {{ $user->username }}
            @endif
            @if ($user->status)
            <span class="ms-1 small" title="{{ $user->status }}">{{ $user->status_emoji }}</span>
            @endif
            @if ($user->isVerified)
                <x-heroicon-s-badge-check class="heroicon ms-1 text-primary verified" />
            @endif
            @if ($user->isPatron)
                <a class="patron" href="{{ route('patron.home') }}" aria-label="Patron">
                    <x-heroicon-s-star class="heroicon text-gold" />
                </a>
            @endif
            <div class="small text-secondary fw-normal">{{ "@" . $user->username }}</div>
        </a>
    </span>
</div>
