<span class="align-middle">
    praised your
    <a class="fw-bold" href="{{ route('task', ['id' => $task->id]) }}">
        task
    </a>
</span>
<div class="mt-2 body-font">
    {!! Purify::clean(Helper::renderTask($task->task)) !!}
</div>
