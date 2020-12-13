<div class="d-flex p-3">
    <div>
        <img class="avatar-50 rounded-circle" src="{{ $user->avatar }}" />
        @if ($user->isPatron)
            <div class="border border-2 border-success mt-2 pl-1 pr-1 rounded-pill small text-center">Patron</div>
        @endif
    </div>
    <div class="ml-3">
        <div class="font-weight-bold text-dark">
            @if ($user->firstname or $user->lastname)
                {{ $user->firstname }}{{ ' '.$user->lastname }}
            @else
                {{ $user->username }}
            @endif
            @if ($user->isVerified)
                <i class="fa fa-check-circle ml-1 text-primary" title="Verified"></i>
            @endif
        </div>
        <div class="small text-dark">{{ '@'.$user->username }}</div>
        @if ($user->bio)
        <div class="mt-2 text-dark">{{ $user->bio }}</div>
        @endif
        @if ($user->location)
        <div class="mt-2 text-dark">
            <i class="fa fa-compass mr-1 text-black-50"></i>
            {{ $user->location }}
        </div>
        @endif
        @if ($user->company)
        <div class="mt-2 text-dark">
            <i class="fa fa-briefcase mr-1 text-black-50"></i>
            {{ $user->company }}
        </div>
        @endif
    </div>
</div>
