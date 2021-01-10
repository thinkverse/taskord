<div wire:init="loadTrendingMakers">
    <div class="text-uppercase fw-bold text-secondary pb-2">
        Trending Makers
    </div>
    <div class="card">
        <div class="card-body">
            @if (!$readyToLoad)
            <div class="text-center">
                <div class="spinner-border spinner-border-sm taskord-spinner text-secondary" role="status"></div>
            </div>
            @else
            🚧
            @endif
        </div>
    </div>
</div>
