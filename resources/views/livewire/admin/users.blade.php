<div class="card" wire:init="loadUsers">
    <div class="card-header h6 pt-3 pb-3">
        <div class="h5">Users</div>
        <span class="fw-bold">{{ $readyToLoad ? $count : '···' }}</span>
        total users
    </div>
    <div class="table-responsive">
        @if (!$readyToLoad)
        <div class="card-body text-center mt-3">
            <div class="spinner-border taskord-spinner text-secondary mb-3" role="status"></div>
            <div class="h6">
                Loading Users...
            </div>
        </div>
        @else
        <table class="table text-dark">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Avatar</th>
                    <th scope="col">Name</th>
                    <th scope="col">Username</th>
                    <th scope="col">Email</th>
                    <th scope="col">Patron</th>
                    <th scope="col">Last IP</th>
                    <th scope="col">Via</th>
                    <th scope="col">Last active</th>
                    <th scope="col">More</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <th>{{ $user->id }}</th>
                    <td>
                        <img loading=lazy class="avatar-30 rounded-circle me-2" src="{{ Helper::getCDNImage($user->avatar, 80) }}" height="30" width="30" alt="{{ $user->username }}'s avatar" />
                    </td>
                    <td class="fw-bold">
                        @if (!$user->firstname and !$user->lastname)
                        <span class="small fw-bold text-secondary">Not Set</span>
                        @else
                        {{ $user->firstname.' '.$user->lastname }}
                        @endif
                        @if ($user->isVerified)
                            <x-heroicon-s-badge-check class="heroicon text-primary ms-1 verified" />
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('user.done', ['username' => $user->username]) }}" target="_blank">
                            {{ '@'.$user->username }}
                        </a>
                        <span class="badge bg-success ms-2">
                            {{ $user->streaks }} {{ str_plural('Streak', $user->streaks) }}
                        </span>
                        @if ($user->isSuspended)
                        <span title="Suspended">
                            🤢
                        </span>
                        @endif
                        @if ($user->isFlagged)
                        <span title="Flagged">
                            🚩
                        </span>
                        @endif
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
                        <span>
                            ❌
                        </span>
                        @else
                        <span>
                            💰
                            @if ($user->patron)
                            ⭐
                            @else
                            🎁
                            @endif
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
                            <img class="brand-icon" src="{{ asset('images/brand/google.svg') }}" />
                        @elseif ($user->provider === 'twitter')
                            <img class="brand-icon" src="{{ asset('images/brand/twitter.svg') }}" />
                        @elseif ($user->provider === 'github')
                            <img class="brand-icon github-logo" src="https://ik.imagekit.io/taskordimg/icons/github_9E8bhMFJtH.svg" />
                        @elseif ($user->provider === 'gitlab')
                            <img class="brand-icon" src="{{ asset('images/brand/gitlab.svg') }}" />
                        @else
                            <x-heroicon-o-globe-alt class="heroicon text-success" />
                        @endif
                    </td>
                    <td title="{{ carbon($user->last_active)->format('M d, Y g:i A') }}">
                        @if ($user->last_active)
                        @if (strtotime(carbon()) - strtotime($user->last_active) <= 5)
                        <span class="fw-bold text-success">active</span>
                        @else
                        {{ carbon($user->last_active)->diffForHumans() }}
                        @endif
                        @else
                        <span class="small fw-bold text-secondary">Not Set</span>
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
            </tbody>
        </table>
        @endif
    </div>
    {{ $readyToLoad ? $users->links() : '' }}
</div>
