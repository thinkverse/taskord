@php
    $badge_class = "badge-font border border-success fw-bold ms-1 px-2 rounded-pill small text-white text-capitalize"
@endphp

@if ($background === 'dark')
<span class="{{ $badge_class }}" title="Feature Release Label: Beta">
    Beta
</span>
@else
<span class="{{ $badge_class }}" title="Feature Release Label: Beta">
    Beta
</span>
@endif
