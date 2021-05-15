<div>
    @php
        $deployed = git('rev-parse HEAD') ?: 'Something went wrong!';
        $remote = $commit->id;
    @endphp
    <div>
        <span class="fw-bold">Status: </span>
        @if ($deployed === $remote)
            <span class="badge bg-success">
                Latest
            </span>
        @else
            <span class="badge bg-danger">
                Update available
            </span>
        @endif
    </div>
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
        {{ carbon($commit->committed_date)->diffForHumans() }}
    </div>
    <div>
        <span class="fw-bold">Author: </span>
        {{ $commit->committer_name }} - {{ $commit->committer_email }}
    </div>
    <div class="mt-2">
        <a href="{{ $commit->web_url }}" class="fw-bold" target="_blank">
            Got to commit
            <x-heroicon-o-external-link class="heroicon" />
        </a>
    </div>
</div>
