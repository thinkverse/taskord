<div>
    <div>
        <span class="fw-bold">Status: </span>
        @if ($ci->status === 'success')
        <span class="badge bg-success">
            Success
        </span>
        @elseif ($ci->status === 'failed')
        <span class="badge bg-danger">
            Failed
        </span>
        @elseif ($ci->status === 'pending')
        <span class="badge bg-secondary">
            Pending
        </span>
        @elseif ($ci->status === 'running')
        <span class="badge bg-info">
            Running
        </span>
        @elseif ($ci->status === 'preparing')
        <span class="badge bg-info">
            Preparing
        </span>
        @elseif ($ci->status === 'canceled')
        <span class="badge bg-info">
            Canceled
        </span>
        @endif
    </div>
    <div>
        <span class="fw-bold">Started: </span>
        {{ carbon($ci->created_at)->diffForHumans() }}
    </div>
    <div>
        <span class="fw-bold">Updated: </span>
        {{ carbon($ci->updated_at)->diffForHumans() }}
    </div>
    <div class="mt-2">
        <a href="{{ $ci->web_url }}" class="fw-bold" target="_blank">
            Got to pipeline
            <x-heroicon-o-external-link class="heroicon" />
        </a>
    </div>
</div>
