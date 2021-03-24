<div>
    @php
        $deployed = git('rev-parse HEAD') ?: 'Something went wrong!';
        $remote = $commit->id;
    @endphp
    @if ($deployed === $remote)
    <div>
        <span class="fw-bold">Status: </span>
        <span class="badge bg-success">
            Latest
        </span>
    </div>
    @else
    <div>
        <span class="fw-bold">Status: </span>
        <span class="badge bg-danger">
            Update available
        </span>
    </div>
    @endif
    <div>
        <span class="fw-bold">Remote: </span>
        <code class="fw-bold">
            {{ $remote }}
        </code>
    </div>
    <div>
        <span class="fw-bold">Deployed: </span>
        <code class="fw-bold">
            {{ $deployed }}
        </code>
    </div>
    <div>
        <span class="fw-bold">Message: </span>
        {{ $commit->title }}
    </div>
    <div>
        <span class="fw-bold">Date: </span>
        {{ $commit->committed_date }}
    </div>
    <div>
        <span class="fw-bold">Author: </span>
        {{ $commit->committer_name }} - {{ $commit->committer_email }}
    </div>
</div>
