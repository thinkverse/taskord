@if (true)
    <div class="card border-success mb-4">
        <div class="card-body">
            <h5>
                <a class="text-dark" href="{{ route('milestones.opened') }}">
                    <x-heroicon-o-truck class="heroicon-2x" />
                    Milestone public beta
                </a>
            </h5>
            <p class="mb-0">
                <a href="{{ route('milestones.opened') }}">Milestones</a> are now available public beta 🎉
            </p>
        </div>
    </div>
@endif
