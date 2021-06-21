<div class="mb-3">
    <a class="mb-2 btn btn-{{ Route::is('milestones.opened') ? '' : 'outline-' }}primary rounded-pill me-2" href="{{ route('milestones.opened') }}">
        Upcoming
    </a>
    <a class="mb-2 btn btn-{{ Route::is('milestones.opened') ? '' : 'outline-' }}primary rounded-pill me-2" href="{{ route('milestones.opened') }}">
        Finised
    </a>
    <a class="mb-2 btn btn-{{ Route::is('milestones.closed') ? '' : 'outline-' }}primary rounded-pill me-2" href="{{ route('milestones.closed') }}">
        RSVPd
    </a>
</div>
