<div>
    @foreach ($deployments->executions as $deployment)
        <div>
            <code>
                {{ $deployment->id }}
            </code>
            @if ($deployment->status === 'SUCCESSFUL')
                <span class="badge bg-success">
                    Deployment Successful
                </span>
            @elseif ($deployment->status === 'FAILED')
                <span class="badge bg-danger">
                    Deployment Failed
                </span>
            @elseif ($deployment->status === 'pending')
                <span class="badge bg-secondary">
                    Deployment Pending
                </span>
            @elseif ($deployment->status === 'running')
                <span class="badge bg-info">
                    In Progress
                </span>
            @elseif ($deployment->status === 'preparing')
                <span class="badge bg-info">
                    Preparing to deploy
                </span>
            @elseif ($deployment->status === 'SKIPPED')
                <span class="badge bg-info">
                    Deployment Skipped
                </span>
            @endif
            <span class="ms-1">
                {{ carbon($deployment->start_date)->diffForHumans() }}
            </span>
            <a href="{{ $deployment->html_url }}" class="fw-bold ms-1" target="_blank">
                <x-heroicon-o-external-link class="heroicon" />
            </a>
        </div>
    @endforeach
</div>
