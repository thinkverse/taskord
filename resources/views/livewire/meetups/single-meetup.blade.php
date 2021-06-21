<div class="card mb-2">
    <a href="#url">
        <img loading=lazy class="card-img-top" src="{{ $meetup->cover }}" alt="{{ $meetup->name }}">
    </a>
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
    </div>
    <livewire:meetups.rsvp :meetup="$meetup" :wire:key="$meetup->id" />
</div>
