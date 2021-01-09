<div wire:init="loadPopularTasks">
    <div class="pb-2 h5 text-secondary">
        Recent popular tasks
    </div>
    @if (!$readyToLoad)
    <div class="card-body text-center mt-3 mb-3">
        <div class="spinner-border taskord-spinner text-secondary mb-3" role="status"></div>
        <div class="h6">
            Loading popular tasks...
        </div>
    </div>
    @endif
</div>
