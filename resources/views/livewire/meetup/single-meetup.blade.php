<div class="col-md-6 col-lg-3 mb-4">
    <div class="card mx-auto">
        <a href="#url">
            <img class="card-img-top" src="{{ $meetup->cover }}" alt="{{ $meetup->name }}">
        </a>
        <div class="card-body">
            <div class="font-weight-bold text-uppercase small">
                @auth
                {{ Carbon::parse($meetup->starts_at)->setTimezone(Auth::user()->timezone)->format('D, M d, H:i') }}
                @else
                {{ Carbon::parse($meetup->starts_at)->format('D, M d, H:i') }}
                @endauth
                @if (Carbon::parse($meetup->starts_at)->isToday())
                <span class="text-black-50">(Happening)</span>
                @endif
            </div>
            <h5 class="card-title mt-2">
                <a href="#url">{{ $meetup->name }}</a>
            </h5>
            <div>
                {{ $meetup->tagline }}
            </div>
        </div>
        @livewire('meetup.rsvp', ['meetup' => $meetup])
    </div>
</div>
