<div class="card" wire:init="loadUsers">
    <div class="card-header h6 py-3">
        <div class="h5">Deployments</div>
        Deployments happend on Taskord
    </div>
    <div class="px-3">
        @if (!$readyToLoad)
            <div class="card-body text-center mt-3">
                <div class="spinner-border taskord-spinner text-secondary mb-3" role="status"></div>
                <div class="h6">
                    Loading users...
                </div>
            </div>
        @else
            @if (count($deployments) === 0)
                <div class="card-body text-center mt-3 mb-3">
                    <x-heroicon-o-cloud class="heroicon heroicon-60px text-primary mb-2" />
                    <div class="h4">
                        No deployments found!
                    </div>
                </div>
            @endif
            @foreach ($deployments as $deployment)
                <div class="card mt-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-2">
                                @if ($deployment->status === 'success')
                                    <span class="badge bg-success p-2">
                                        Deployment Successful
                                    </span>
                                @elseif ($deployment->status === 'failed')
                                    <span class="badge bg-danger p-2">
                                        Deployment Failed
                                    </span>
                                @elseif ($deployment->status === 'pending')
                                    <span class="badge bg-secondary p-2">
                                        Deployment Pending
                                    </span>
                                @elseif ($deployment->status === 'running')
                                    <span class="badge bg-info p-2">
                                        In Progress
                                    </span>
                                @elseif ($deployment->status === 'preparing')
                                    <span class="badge bg-info p-2">
                                        Preparing to deploy
                                    </span>
                                @elseif ($deployment->status === 'canceled')
                                    <span class="badge bg-info p-2">
                                        Deployment Canceled
                                    </span>
                                @endif
                            </div>
                            <div class="col-2">
                                <span>
                                    Deployment ID:
                                </span>
                                <code class="fw-bold">
                                    {{ $deployment->id }}
                                </code>
                            </div>
                            <div class="col-2">
                                <span class="text-secondary">
                                    {{ carbon($deployment->updated_at)->diffForHumans() }}
                                </span>
                                <a href="{{ $deployment->web_url }}" class="fw-bold ms-1" target="_blank">
                                    <x-heroicon-o-external-link class="heroicon" />
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
