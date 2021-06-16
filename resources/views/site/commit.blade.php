<div>
    <div>
        {{ count($commit) }}
        <span class="fw-bold">Status: </span>
        @if (count($commit) === 0)
            <span class="badge bg-success">
                Latest
            </span>
        @else
            <span class="badge bg-danger">
                Update available
            </span>
        @endif
    </div>
</div>
