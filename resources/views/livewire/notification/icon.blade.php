<li class="nav-item me-2">
    <a class="nav-link text-white" href="{{ route('notifications.unread') }}" aria-label="Notifications">
        <x-heroicon-o-bell class="heroicon-notification me-0" />
        @auth
            @if (auth()->user()->unreadNotifications->count('id') !== 0)
                <span class="badge badge-pill bg-danger fw-bold small ms-1 p-1">
                    {{ auth()->user()->unreadNotifications->count('id') }}
                </span>
            @endif
        @endauth
    </a>
</li>
