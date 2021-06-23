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
                <x-heroicon-o-chat-alt-2 class="heroicon heroicon-60px text-primary mb-2" />
                <div class="h4">
                    No milestones made
                </div>
            </div>
        @endif
        @foreach ($milestones as $milestone)
            <livewire:milestone.single-milestone type="milestones.opened" :milestone="$milestone"
                :wire:key="$milestone->id" />
        @endforeach

        {{ $milestones->links() }}
    @endif
</div>
