<div>
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
</div>
