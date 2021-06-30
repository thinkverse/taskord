<div wire:init="loadBadges">
    @if (!$readyToLoad)
        Loading
    @else
        @foreach ($badges as $badge)
            {{ $badge }}
        @endforeach
    @endif
</div>
