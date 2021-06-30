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
            <div class="card-body">
                @foreach ($badges as $badge)
                    <span class="border py-1 px-3 mb-2 mr-2 rounded-pill d-inline-flex align-items-center"
                        style="border-color: {{ $badge->color }} !important; color: {{ $badge->color }}">
                        <img src="{{ $badge->icon }}" class="avatar-15 me-1" />
                        <span>{{ $badge->title }}</span>
                    </span>
                @endforeach
            </div>
        @endif
    @endif
</div>
