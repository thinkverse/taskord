<div class="card" wire:init="loadStats">
    <div class="card-header h6 pt-3 pb-3">
        <div class="h5">Stats</div>
        Taskord Stats
    </div>
    <div class="card-body">
        @if (!$readyToLoad)
        <div class="card-body text-center mt-3">
            <div class="spinner-border taskord-spinner text-secondary mb-3" role="status"></div>
            <div class="h6">
                Loading stats...
            </div>
        </div>
        @else
        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-header fw-bold d-flex align-items-center">
                        <x-heroicon-o-database class="heroicon me-1" />
                        <span>Disk usage</span>
                    </div>
                    <div class="card-body">
                        <div class="h5 mb-0">
                            {{ $stats['praises'] }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
