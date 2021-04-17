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
                        <x-heroicon-o-check class="heroicon me-1" />
                        <span>Tasks</span>
                    </div>
                    <div class="card-body">
                        <div class="h5 mb-0">
                            {{ $stats['tasks'] }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-header fw-bold d-flex align-items-center">
                        <x-heroicon-o-users class="heroicon me-1" />
                        <span>Users</span>
                    </div>
                    <div class="card-body">
                        <div class="h5 mb-0">
                            {{ $stats['users'] }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-header fw-bold d-flex align-items-center">
                        <x-heroicon-o-cube class="heroicon me-1" />
                        <span>Products</span>
                    </div>
                    <div class="card-body">
                        <div class="h5 mb-0">
                            {{ $stats['products'] }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-header fw-bold d-flex align-items-center">
                        <x-heroicon-o-question-mark-circle class="heroicon me-1" />
                        <span>Questions</span>
                    </div>
                    <div class="card-body">
                        <div class="h5 mb-0">
                            {{ $stats['questions'] }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-header fw-bold d-flex align-items-center">
                        <x-heroicon-o-chat-alt-2 class="heroicon me-1" />
                        <span>Answers</span>
                    </div>
                    <div class="card-body">
                        <div class="h5 mb-0">
                            {{ $stats['answers'] }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-header fw-bold d-flex align-items-center">
                        <x-heroicon-o-chat-alt class="heroicon me-1" />
                        <span>Comments</span>
                    </div>
                    <div class="card-body">
                        <div class="h5 mb-0">
                            {{ $stats['comments'] }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-header fw-bold d-flex align-items-center">
                        <x-heroicon-o-fire class="heroicon me-1" />
                        <span>Reputations</span>
                    </div>
                    <div class="card-body">
                        <div class="h5 mb-0">
                            {{ $stats['reputations'] }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-header fw-bold d-flex align-items-center">
                        <x-heroicon-o-thumb-up class="heroicon me-1" />
                        <span>Praises</span>
                    </div>
                    <div class="card-body">
                        <div class="h5 mb-0">
                            {{ $stats['praises'] }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-header fw-bold d-flex align-items-center">
                        <x-heroicon-o-bell class="heroicon me-1" />
                        <span>Notifications</span>
                    </div>
                    <div class="card-body">
                        <div class="h5 mb-0">
                            {{ $stats['notifications'] }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-header fw-bold d-flex align-items-center">
                        <x-heroicon-o-cloud-upload class="heroicon me-1" />
                        <span>Webhooks</span>
                    </div>
                    <div class="card-body">
                        <div class="h5 mb-0">
                            {{ $stats['webhooks'] }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-header fw-bold d-flex align-items-center">
                        <x-heroicon-o-switch-horizontal class="heroicon me-1" />
                        <span>Interactions</span>
                    </div>
                    <div class="card-body">
                        <div class="h5 mb-0">
                            {{ $stats['interactions'] }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-header fw-bold d-flex align-items-center">
                        <x-heroicon-o-collection class="heroicon me-1" />
                        <span>Logs</span>
                    </div>
                    <div class="card-body">
                        <div class="h5 mb-0">
                            {{ $stats['logs'] }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
