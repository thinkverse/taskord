<div>
    @if ($task)
    <div class="mt-2">
        praised your
        <a class="fw-bold" href="{{ route('task', ['id' => $task->id]) }}">
            task
        </a>
    </div>
    <div class="mt-2 body-font">
        {!! Purify::clean(Helper::renderTask($task->task)) !!}
    </div>
    @else
    <div class="body-font fst-italic text-secondary mt-2">Notification source was deleted</div>
    @endif
</div>
