<div>
    <div class="card-body">
        <div class="d-flex align-items-center">
            <a href="{{ route('user.done', ['username' => $answer->user->username]) }}">
                <img loading=lazy class="avatar-40 rounded-circle" src="{{ Helper::getCDNImage($answer->user->avatar, 80) }}" height="40" width="40" alt="{{ $answer->user->username }}'s avatar" />
            </a>
            <span class="ms-2">
                <a
                    href="{{ route('user.done', ['username' => $answer->user->username]) }}"
                    class="fw-bold text-dark user-popover"
                    data-id="{{ $answer->user->id }}"
                >
                    @if ($answer->user->firstname or $answer->user->lastname)
                        {{ $answer->user->firstname }}{{ ' '.$answer->user->lastname }}
                    @else
                        {{ $answer->user->username }}
                    @endif
                    @if ($answer->user->status)
                    <span class="ms-1 small" title="{{ $answer->user->status }}">{{ $answer->user->status_emoji }}</span>
                    @endif
                    @if ($answer->user->isVerified)
                    <x-heroicon-s-badge-check class="heroicon ms-1 text-primary verified" />
                    @endif
                    @if ($answer->user->isPatron)
                        <a class="patron" href="{{ route('patron.home') }}" aria-label="Patron">
                            <x-heroicon-s-star class="heroicon text-gold" />
                        </a>
                    @endif
                </a>
                <div class="small">{{ "@" . $answer->user->username }}</div>
            </span>
            <span class="align-text-top small float-end ms-auto">
                <a class="text-secondary" href="">
                    {{ carbon($answer->created_at)->diffForHumans() }}
                </a>
            </span>
        </div>
    </div>
    <div class="card-body pt-1">
        @if ($answer->hidden)
        <span class="body-font fst-italic text-secondary">Answer was hidden by moderator</span>
        @else
        <div class="body-font">
            {!! markdown($answer->answer) !!}
        </div>
        @endif
        <div class="mt-2">
            @auth
            @if (auth()->user()->hasLiked($answer))
                <button type="button" class="btn btn-task btn-success text-white me-1" wire:click="togglePraise" wire:loading.attr="disabled" wire:offline.attr="disabled" aria-label="Praise">
                    <x-heroicon-s-thumb-up class="heroicon-small me-0" />
                    <span class="small text-white fw-bold">
                        {{ number_format($answer->likerscount()) }}
                    </span>
                    <span class="avatar-stack ms-1">
                    @foreach($answer->likers->take(5) as $user)
                    <img loading=lazy class="praise-avatar rounded-circle {{ $loop->last ? 'me-0' : '' }}" src="{{ Helper::getCDNImage($user->avatar, 80) }}" height="15" width="15" alt="{{ $user->username }}'s avatar" />
                    @endforeach
                    </span>
                </button>
            @else
                <button type="button" class="btn btn-task btn-outline-success me-1" wire:click="togglePraise" wire:loading.attr="disabled" wire:offline.attr="disabled" aria-label="Praises">
                    <x-heroicon-o-thumb-up class="heroicon-small me-0 text-secondary" />
                    @if ($answer->likerscount() !== 0)
                    <span class="small text-dark fw-bold">
                        {{ number_format($answer->likerscount()) }}
                    </span>
                    <span class="avatar-stack ms-1">
                    @foreach($answer->likers->take(5) as $user)
                    <img loading=lazy class="praise-avatar rounded-circle {{ $loop->last ? 'me-0' : '' }}" src="{{ Helper::getCDNImage($user->avatar, 80) }}" height="15" width="15" alt="{{ $user->username }}'s avatar" />
                    @endforeach
                    </span>
                    @endif
                </button>
            @endif
            @if (auth()->user()->staffShip or auth()->user()->id === $answer->user->id)
            <button
                type="button"
                class="btn btn-task btn-outline-danger"
                onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
                wire:click="deleteAnswer"
                wire:loading.attr="disabled"
                wire:offline.attr="disabled"
                aria-label="Delete"
            >
                <x-heroicon-o-trash class="heroicon-small me-0 text-secondary" />
            </button>
            @endif
            @if (auth()->user()->staffShip)
            <button type="button" class="btn btn-task {{ $answer->hidden ? 'btn-info' : 'btn-outline-info' }} ms-1" wire:click="hide" wire:loading.attr="disabled" wire:offline.attr="disabled" wire:key="{{ $answer->id }}" title="Flag to admins" aria-label="Hide">
                <x-heroicon-o-eye-off class="heroicon-small me-0" />
            </button>
            @endif
            @endauth
            @guest
                <a href="/login" class="btn btn-task btn-outline-success me-1" aria-label="Praises">
                    <x-heroicon-o-thumb-up class="heroicon-small me-0 text-secondary" />
                    @if ($answer->likerscount() !== 0)
                    <span class="small text-dark fw-bold">
                        {{ number_format($answer->likerscount()) }}
                    </span>
                    <span class="avatar-stack ms-1">
                    @foreach($answer->likers->take(5) as $user)
                    <img loading=lazy class="praise-avatar rounded-circle {{ $loop->last ? 'me-0' : '' }}" src="{{ Helper::getCDNImage($user->avatar, 80) }}" height="15" width="15" alt="{{ $user->username }}'s avatar" />
                    @endforeach
                    </span>
                    @endif
                </a>
            @endguest
        </div>
    </div>
</div>
