<div class="align-items-center d-flex">
    <a
        href="{{ route('user.done', ['username' => $user->username]) }}"
        class="user-popover"
        data-id="{{ $user->id }}"
    >
        <img loading=lazy class="avatar-25 rounded-circle" src="{{ Helper::getCDNImage($user->avatar, 80) }}" height="40" width="40" alt="{{ $user->username }}'s avatar" />
    </a>
    <div class="ms-2 d-flex align-items-center">
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
            @if ($user->is_verified)
                <x-heroicon-s-badge-check class="heroicon ms-1 text-primary verified" />
            @endif
            @if ($user->is_patron)
                <a class="badge tk-badge bg-patron text-capitalize ms-1" href="{{ route('patron.home') }}">
                    Patron
                </a>
            @endif
            @if ($user->is_staff)
                <span class="badge tk-badge bg-staff text-capitalize ms-1">
                    Staff
                </span>
            @endif
            <span class="small text-secondary fw-normal ms-2">{{ "@" . $user->username }}</span>
        </a>
    </div>
</div>
