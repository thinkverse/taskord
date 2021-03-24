<div>
    <div class="d-flex align-items-center">
        @if ($ci->status === 'success')
        <div title="Success">
            <span class="badge bg-success">
                <x-heroicon-o-check class="heroicon-2x me-0" />
            </span>
        </div>
        @elseif ($ci->status === 'failed')
        <div title="Failed">
            <span class="badge bg-danger">
                <x-heroicon-o-x class="heroicon-2x me-0" />
            </span>
        </div>
        @elseif ($ci->status === 'pending')
        <div title="Pending">
            <span class="badge bg-info">
                <x-heroicon-o-pause class="heroicon-2x me-0" />
            </span>
        </div>
        @elseif ($ci->status === 'running')
        <div title="Running">
            <span class="badge bg-info">
                <x-heroicon-o-play class="heroicon-2x me-0" />
            </span>
        </div>
        @elseif ($ci->status === 'preparing')
        <div title="Preparing">
            <span class="badge bg-info">
                <x-heroicon-o-fire class="heroicon-2x me-0" />
            </span>
        </div>
        @elseif ($ci->status === 'canceled')
        <div title="Canceled">
            <span class="badge bg-info">
                <x-heroicon-o-exclamation-circle class="heroicon-2x me-0" />
            </span>
        </div>
        @endif
        <a href="{{ $ci->web_url }}" class="fw-bold ms-2" target="_blank">
            Got to pipeline
            <x-heroicon-o-external-link class="heroicon" />
        </a>
    </div>
    @if ($ci->status === 'failed')
    <h5 class="mt-2 fw-bold text-danger">Please don't Deploy</h5>
    @endif
</div>
