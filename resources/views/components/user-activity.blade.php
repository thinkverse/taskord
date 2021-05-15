<li class="list-group-item py-3 d-flex align-items-center">
    @php
        $user = App\Models\User::find($activity->causer_id);
        if (!$user) {
            $user = \App\Models\User::where('username', 'ghost')->first();
        }
    @endphp
    <a href="{{ route('user.done', ['username' => $user->username]) }}">
        <img loading=lazy class="avatar-30 rounded-circle me-3" src="{{ Helper::getCDNImage($user->avatar, 80) }}" height="40" width="40" alt="{{ $user->username }}'s avatar" />
    </a>
    <div>
        <div>
            <div class="fw-bold text-dark">
                <a
                    href="{{ route('user.done', ['username' => $user->username]) }}"
                    class="fw-bold user-popover"
                    data-id="{{ $user->id }}"
                >
                    {{ "@" . $user->username }}
                </a>
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
                    @if ($activity->getExtraProperty('type') === 'Milestone')
                        ⛳ Milestone
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
            @if (auth()->user()->staffShip)
                <span class="font-monospace text-secondary" title="Log ID">Log ID: {{ $activity->id }}</span>
                <span class="vertical-separator"></span>
            @endif
            @if ($activity->getExtraProperty('ip'))
                <a class="font-monospace fw-bold" href="https://ipinfo.io/{{ $activity->getExtraProperty('ip') }}" target="_blank" rel="noreferrer">
                    {{ Str::limit($activity->getExtraProperty('ip'), 15, '..') }}
                </a>
                <span class="vertical-separator"></span>
            @endif
            @if ($activity->getExtraProperty('location'))
                <span class="text-dark">{{ $activity->getExtraProperty('location') }}</span>
                <span class="vertical-separator"></span>
            @endif
            @if ($activity->getExtraProperty('user_agent') and auth()->user()->staffShip)
                <a
                    class="cursor-pointer text-dark"
                    href="https://userstack.com/ua_api.php?ua={{ $activity->getExtraProperty('user_agent') }}"
                    title="{{ $activity->getExtraProperty('user_agent') }}"
                    target="_blank"
                >
                    <x-heroicon-o-globe-alt class="heroicon" />
                </a>
                <span class="vertical-separator"></span>
            @endif
            <span class="text-secondary">
                {{ carbon($activity->created_at)->diffForHumans() }}
            </span>
        </div>
    </div>
</li>
