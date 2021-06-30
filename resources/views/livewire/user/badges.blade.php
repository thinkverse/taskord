<div wire:init="loadBadges">
    @if (!$readyToLoad)
        <div class="card-body">
            <div class="spinner-border spinner-border-sm taskord-spinner text-secondary me-2" role="status"></div>
            Loading badges...
        </div>
    @else
        @if (count($badges) === 0)
            <div class="card-body">
                This user has no badges
            </div>
        @else
            <div class="card-body pb-2">
                @foreach ($badges as $badge)
                    <a class="border py-1 px-3 mb-2 mr-2 rounded-pill d-inline-flex align-items-center"
                        href="{{ route('badges.badge', ['slug' => $badge->slug]) }}"
                        style="border-color: {{ $badge->color }} !important; color: {{ $badge->color }}">
                        <img src="{{ $badge->icon }}" class="avatar-15 me-2" />
                        <span>{{ $badge->title }}</span>
                    </a>
                @endforeach
            </div>
        @endif
    @endif
</div>
