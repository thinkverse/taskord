<div class="card" wire:init="loadUsers">
    <div class="card-header h6 py-3">
        <div class="h5">Users</div>
        <span class="fw-bold">{{ $readyToLoad ? $count : '···' }}</span>
        total users
    </div>
    <div class="px-3">
        @if (!$readyToLoad)
            <div class="card-body text-center mt-3">
                <div class="spinner-border taskord-spinner text-secondary mb-3" role="status"></div>
                <div class="h6">
                    Loading users...
                </div>
            </div>
        @else
            @foreach ($users as $user)
                <div class="card mt-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <x:shared.user-label-big :user="$user" />
                            <div title="{{ carbon($user->last_active)->format('M d, Y g:i A') }}">
                                @if ($user->last_active)
                                    @if (strtotime(carbon()) - strtotime($user->last_active) <= 5)
                                        <span class="fw-bold text-success">active</span>
                                    @else
                                        {{ carbon($user->last_active)->diffForHumans() }}
                                    @endif
                                @else
                                    <span class="small fw-bold text-secondary">Not Set</span>
                                @endif
                            </div>
                        </div>
                        <div class="pt-3 text-dark">
                            {{ $user->bio }}
                        </div>
                        <hr />
                        <div class="row">
                            <div class="col-lg">
                                <div>
                                    <span>User ID:</span>
                                    <span class="text-secondary fw-bold me-2">#{{ $user->id }}</span>
                                </div>
                                <div class="mt-1">
                                    <span>Status:</span>
                                    @if ($user->isSuspended)
                                        <span class="badge bg-danger">
                                            Suspended
                                        </span>
                                    @endif
                                    @if ($user->isFlagged)
                                        <span class="badge bg-info">
                                            Flagged
                                        </span>
                                    @endif
                                    @if (!$user->isSuspended or !$user->isFlagged)
                                        <span class="badge bg-success">
                                            Good
                                        </span>
                                    @endif
                                </div>
                                <div class="mt-1">
                                    <span>Streaks:</span>
                                    <span class="badge bg-success">
                                        {{ $user->streaks }} {{ str_plural('Streak', $user->streaks) }}
                                    </span>
                                </div>
                                <div>
                                    Hi
                                </div>
                                <div>
                                    Hi
                                </div>
                                <div>
                                    Hi
                                </div>
                            </div>
                            <div class="col-lg">
                                Hi
                            </div>
                        </div>
                        <div class="pt-3">
                            
                            
                        </div>
                    </div>
                </div>
                <tr>
                    <td>
                        
                    </td>
                    <td>
                        {{ $user->email }}
                        @if ($user->hasVerifiedEmail())
                            <span title="Email Verified">
                                <x-heroicon-o-check class="heroicon ms-1 text-success" />
                            </span>
                        @else
                            <span title="Email not Verified">
                                <x-heroicon-o-x class="heroicon ms-1 text-danger" />
                            </span>
                        @endif
                    </td>
                    <td>
                        @if (!$user->isPatron)
                            <span>❌</span>
                        @else
                            <span>
                                💰
                                @if ($user->patron)⭐@else🎁@endif
                            </span>
                        @endif
                    </td>
                    <td>
                        @if ($user->lastIP)
                            <a class="font-monospace" href="https://ipinfo.io/{{ $user->lastIP }}" title="{{ $user->lastIP }}" target="_blank" rel="noreferrer">
                                {{ Str::limit($user->lastIP, 15, '..') }}
                            </a>
                        @else
                            <span class="small fw-bold text-secondary">Not logged</span>
                        @endif
                    </td>
                    <td>
                        @if ($user->provider === 'google')
                            <img class="brand-icon" src="https://ik.imagekit.io/taskordimg/icons/google_LPvasOP5AT.svg" loading=lazy />
                        @elseif ($user->provider === 'twitter')
                            <img class="brand-icon" src="https://ik.imagekit.io/taskordimg/icons/twitter_4cXueyhRfH.svg" loading=lazy />
                        @elseif ($user->provider === 'github')
                            <img class="brand-icon github-logo" src="https://ik.imagekit.io/taskordimg/icons/github_9E8bhMFJtH.svg" loading=lazy />
                        @elseif ($user->provider === 'discord')
                            <img class="brand-icon" src="https://ik.imagekit.io/taskordimg/icons/discord_MCCBaztWr.webp" loading=lazy />
                        @else
                            <x-heroicon-o-globe-alt class="heroicon text-success" />
                        @endif
                    </td>
                    
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                More
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <span class="dropdown-item">
                                        <x-heroicon-o-check class="heroicon text-secondary" />
                                        <span class="fw-bold">{{ $user->tasks()->count('id') }}</span> Tasks
                                    </span>
                                </li>
                                <li>
                                    <span class="dropdown-item">
                                        <x-heroicon-o-chat-alt class="heroicon text-secondary" />
                                        <span class="fw-bold">{{ $user->comments()->count('id') }}</span> Comments
                                    </span>
                                </li>
                                <li>
                                    <span class="dropdown-item">
                                        <x-heroicon-o-question-mark-circle class="heroicon text-secondary" />
                                        <span class="fw-bold">{{ $user->questions()->count('id') }}</span> Questions
                                    </span>
                                </li>
                                <li>
                                    <span class="dropdown-item">
                                        <x-heroicon-o-chat-alt-2 class="heroicon text-secondary" />
                                        <span class="fw-bold">{{ $user->answers()->count('id') }}</span> Answers
                                    </span>
                                </li>
                                <li>
                                    <span class="dropdown-item">
                                        <x-heroicon-o-cube class="heroicon text-secondary" />
                                        <span class="fw-bold">{{ $user->ownedProducts('id')->count('id') }}</span> Products
                                    </span>
                                </li>
                                <li>
                                    <span class="dropdown-item">
                                        <x-heroicon-o-user-add class="heroicon text-secondary" />
                                        <span class="fw-bold">{{ $user->products()->count() }}</span> Membership
                                    </span>
                                </li>
                                <li>
                                    <span class="dropdown-item">
                                        <x-heroicon-o-bell class="heroicon text-secondary" />
                                        <span class="fw-bold">{{ $user->notifications()->count('id') }}</span> Notifications
                                    </span>
                                </li>
                                <li>
                                    <span class="dropdown-item">
                                        <x-heroicon-o-cloud-upload class="heroicon text-secondary" />
                                        <span class="fw-bold">{{ $user->webhooks()->count('id') }}</span> Webhooks
                                    </span>
                                </li>
                                <li>
                                    <span class="dropdown-item">
                                        <x-heroicon-o-clock class="heroicon text-secondary" />
                                        <span class="fw-bold">{{ $user->timezone }}</span>
                                    </span>
                                </li>
                                <li>
                                    <span class="dropdown-item" title="{{ $user->updated_at->format('M d, Y g:i A') }}">
                                        <x-heroicon-o-calendar class="heroicon text-secondary" />
                                        <span class="fw-bold">{{ $user->updated_at->format('M d, Y') }}</span>
                                    </span>
                                </li>
                                <li>
                                    <span class="dropdown-item" title="{{ $user->created_at->format('M d, Y g:i A') }}">
                                        <x-heroicon-o-calendar class="heroicon text-secondary" />
                                        <span class="fw-bold">{{ $user->created_at->format('M d, Y') }}</span>
                                        @if ($user->created_at->diffInDays(carbon('today')) < 7)
                                            🆕
                                        @endif
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
            @endforeach
        @endif
    </div>
    {{ $readyToLoad ? $users->links() : '' }}
</div>
