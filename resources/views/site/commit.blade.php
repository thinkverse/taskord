<div>
    <div>
        <span class="fw-bold">Status: </span>
        @if (count($commits) === 0)
            <span class="badge bg-success">
                Taskord is in latest version
            </span>
        @else
            <span class="badge bg-danger">
                Updates available
            </span>
        @endif
        @if (count($commits) !== 0)
            <ul class="bg-patron-question mt-3 py-2 rounded border border-warning">
                @foreach ($commits as $commit)
                    <li>
                        {{ $commit->title }}
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
