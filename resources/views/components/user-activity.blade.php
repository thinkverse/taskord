<li class="list-group-item py-3">
    @php
    $user = App\Models\User::find($activity->causer_id);
    if (!$user) {
        $user = \App\Models\User::where('username', 'ghost')->first();
    }
    @endphp
    <div class="align-items-center d-flex">
        <a href="{{ route('user.done', ['username' => $user->username]) }}">
            <img loading=lazy class="avatar-30 rounded-circle" src="{{ Helper::getCDNImage($user->avatar, 80) }}" height="40" width="40" alt="{{ $user->username }}'s avatar" />
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
                @if ($user->isVerified)
                    <x-heroicon-s-badge-check class="heroicon ms-1 text-primary verified" />
                @endif
                @if ($user->isPatron)
                    <a class="patron" href="{{ route('patron.home') }}" aria-label="Patron">
                        <x-heroicon-s-star class="heroicon text-gold" />
                    </a>
                @endif
                <span class="small text-secondary fw-normal">{{ "@" . $user->username }}</span>
            </a>
        </span>
        <span class="align-text-top small float-end ms-auto text-secondary">
            {{ $activity->created_at->format('D, d M Y H:i:s') }} GMT
        </span>
    </div>
    <div class="mt-3">
        <div class="fw-bold">
            <span class="fw-normal" title="Log ID">{{ $activity->id }}</span>
            •
            @if (count($activity->properties) !== 0)
                @if ($activity->getExtraProperty('type') === 'Admin')
                    🛡 Admin
                @endif
                @if ($activity->getExtraProperty('type') === 'Auth')
                    🚪 Auth
                @endif
                @if ($activity->getExtraProperty('type') === 'Task')
                    ✅ Task
                @endif
                @if ($activity->getExtraProperty('type') === 'Answer')
                    💬 Answer
                @endif
                @if ($activity->getExtraProperty('type') === 'Comment')
                    💬 Comment
                @endif
                @if ($activity->getExtraProperty('type') === 'Question')
                    ❓ Question
                @endif
                @if ($activity->getExtraProperty('type') === 'User')
                    👤 User
                @endif
                @if ($activity->getExtraProperty('type') === 'Product')
                    📦 Product
                @endif
                @if ($activity->getExtraProperty('type') === 'Notification')
                    🔔 Notification
                @endif
                @if ($activity->getExtraProperty('type') === 'Search')
                    🔍 Search
                @endif
                @if ($activity->getExtraProperty('type') === 'Throttle')
                    🛑 Throttled
                @endif
            @else
                🌐 Others
            @endif
            <span> • {{ $activity->description }}</span>
        </div>
    </div>
    <div class="mt-2">
        @if ($activity->getExtraProperty('ip'))
        <a class="font-monospace fw-bold" href="https://ipinfo.io/{{ $activity->getExtraProperty('ip') }}" target="_blank" rel="noreferrer">
            {{ Str::limit($activity->getExtraProperty('ip'), 15, '..') }}
        </a>
        <span class="vertical-separator"></span>
        @endif
        @if ($activity->getExtraProperty('location'))
        <span>{{ $activity->getExtraProperty('location') }}</span>
        <span class="vertical-separator"></span>
        @endif
        {{ carbon($activity->created_at)->diffForHumans() }}
    </div>
</li>
