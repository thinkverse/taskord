<div wire:init="loadMilestones">
    @if (!$readyToLoad)
        <div>
            <x:loaders.milestone-skeleton count="1" />
        </div>
        <div class="mt-2">
            <x:loaders.milestone-skeleton count="1" />
        </div>
        <div class="mt-2">
            <x:loaders.milestone-skeleton count="1" />
        </div>
    @else
        @if (count($milestones) === 0)
            <div class="card-body text-center mt-3 mb-3">
                <x-heroicon-o-truck class="heroicon heroicon-60px text-primary mb-2" />
                <div class="h4">
                    No milestones found
                </div>
            </div>
        @endif
        @foreach ($milestones as $milestone)
            <livewire:milestone.single-milestone :type="$type" :milestone="$milestone" :wire:key="$milestone->id" />
        @endforeach
        @if ($milestones->hasMorePages())
            <livewire:milestone.load-more :type="$type" :page="$page" :perPage="$perPage" />
        @endif
    @endif
</div>
