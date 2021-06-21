<div class="card mb-2">
    <div class="card-body">
        <div class="fw-bold text-uppercase small">
            @auth
                {{ carbon($meetup->date)->setTimezone(auth()->user()->timezone)->format('D, M d, H:i') }}
            @else
                {{ carbon($meetup->date)->format('D, M d, H:i') }}
            @endauth
            @if (carbon($meetup->date)->isToday())
                <span class="text-secondary">(Happening)</span>
            @endif
        </div>
        <h5 class="card-title mt-2">
            <a href="#url">{{ $meetup->name }}</a>
        </h5>
        <div>
            {{ $meetup->tagline }}
        </div>
        <div class="mt-3 fw-bold">Attending</div>
        <div class="mt-2">
            <img loading=lazy class="avatar-25 rounded-circle" src="{{ Helper::getCDNImage($meetup->user->avatar, 80) }}" height="25" width="25" alt="{{ $meetup->user->username }}'s avatar" />
            @foreach($meetup->subscribers as $user)
                <img loading=lazy class="avatar-25 rounded-circle" src="{{ Helper::getCDNImage($user->avatar, 80) }}" height="25" width="25" alt="{{ $user->username }}'s avatar" />
            @endforeach
        </div>
        <div class="mt-3">
            @auth
                @if (auth()->user()->hasSubscribed($meetup))
                    <button class="btn btn-sm btn-danger text-white fw-bold" wire:click="toggleRSVP" wire:loading.attr="disabled" aria-label="Can't Attend">
                        ❌ Can't attend
                    </button>
                @else
                    <button class="btn btn-sm btn-outline-success text-dark" wire:click="toggleRSVP" wire:loading.attr="disabled" aria-label="RSVP">
                        ✅ RSVP
                    </button>
                @endif
            @else
                <a class="btn btn-sm btn-outline-secondary text-dark" href="{{ route('login') }}" aria-label="RSVP">
                    ✅ RSVP
                </a>
            @endauth
        </div>
    </div>
</div>
