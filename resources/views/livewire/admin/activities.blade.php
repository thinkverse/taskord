<div class="card" wire:init="loadActivities" wire:poll>
    <div class="card-header h6 pt-3 pb-3">
        <div class="h5">Activities</div>
        <span class="fw-bold">{{ $readyToLoad ? $count : '···' }}</span>
        total activities
    </div>
    <div class="table-responsive">
        @if ($readyToLoad)
        <table class="table table-borderless text-dark">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">TimeStamp</th>
                    <th scope="col">IP Address</th>
                    <th scope="col">Caused by</th>
                    <th scope="col">Type</th>
                    <th scope="col">Description</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($activities as $activity)
                <tr>
                    <td>{{ $activity->id }}</td>
                    <td class="text-secondary">
                        {{ $activity->created_at->format('D, d M Y H:i:s') }} GMT
                    </td>
                    <td>
                        @if ($activity->getExtraProperty('ip'))
                        <a class="font-monospace" href="https://ipinfo.io/{{ $activity->getExtraProperty('ip') }}" target="_blank" rel="noreferrer">
                            {{ $activity->getExtraProperty('ip') }}
                        </a>
                        @else
                        <span class="small fw-bold text-secondary">Not logged</span>
                        @endif
                    </td>
                    <td>
                        @if($activity->causer_id)
                            @php
                            $user = App\Models\User::find($activity->causer_id);
                            @endphp
                            @if ($user)
                            <img loading=lazy class="avatar-20 mb-1 me-1 rounded-circle" src="{{ Helper::getCDNImage($user->avatar, 80) }}" height="20" width="20" alt="{{ $user->username }}'s avatar" />
                            <a
                                class="user-popover"
                                data-id="{{ $user->id }}"
                                href="{{ route('user.done', ['username' => $user->username]) }}"
                            >
                                {{ '@' . $user->username }}
                            </a>
                            @else
                            <span class="text-danger">Deleted User</span>
                            @endif
                        @else
                        <span class="text-info">Anonymous</span>
                        @endif
                    </td>
                    <td>
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
                    </td>
                    <td class="fw-bold">{{ $activity->description }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
        @if (!$readyToLoad)
        <div class="card-body text-center mt-3">
            <div class="spinner-border taskord-spinner text-secondary mb-3" role="status"></div>
            <div class="h6">
                Loading activities...
            </div>
        </div>
        @endif
    </div>
    {{ $readyToLoad ? $activities->links() : '' }}
</div>
