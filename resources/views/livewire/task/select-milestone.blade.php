<span class="dropdown">
    <a class="btn btn-task btn-outline-info dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
        <x-heroicon-o-truck class="heroicon-small text-secondary" />
    </a>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
        @foreach ($milestones as $milestone)
            <li>
                <a class="dropdown-item" href="#" wire:click="selectMilestone">
                    <span class="text-secondary me-2 fw-bold">#{{ $milestone->id }}</span>
                    <span>{{ $milestone->name }}</span>
                </a>
            </li>
        @endforeach
    </ul>
</span>
