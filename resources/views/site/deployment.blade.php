<div>
    @foreach ($deployments->executions as $deployment)
        <div>
            <code>
                ID: {{ $deployment->id }}
            </code>
            @if ($deployment->status === 'SUCCESSFUL')
                <span class="badge bg-success">
                    Deployment Successful
                </span>
            @elseif ($deployment->status === 'FAILED')
                <span class="badge bg-danger">
                    Deployment Failed
                </span>
            @elseif ($deployment->status === 'ENQUEUED')
                <span class="badge bg-secondary">
                    Deployment Pending
                </span>
            @elseif ($deployment->status === 'INPROGRESS')
                <span class="badge bg-info">
                    In Progress
                </span>
            @elseif ($deployment->status === 'TERMINATED')
                <span class="badge bg-danger">
                    Deployment Terminated
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
