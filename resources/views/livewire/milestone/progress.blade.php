<div>
    <div class="progress w-50" style="height:6px" title="{{ $percent }}% completed">
        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $percent }}%;" aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <div class="mt-1">
        <span class="me-2">
            <span class="fw-bold">{{ $completed }}</span> completed
        </span>
        <span class="me-2">
            <span class="fw-bold">{{ $pending }}</span> pending
        </span>
    </div>
</div>
