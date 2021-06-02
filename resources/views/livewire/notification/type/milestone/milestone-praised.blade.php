<div>
    @if ($milestone)
        <div class="mt-2 text-secondary">
            praised your
            <a class="fw-bold" href="{{ route('milestones.milestone', ['milestone' => $milestone]) }}">
                milestone
            </a>
        </div>
        <div class="mt-3">
            <livewire:comment.single-comment :comment="$comment" :wire:key="$comment->id" />
        </div>
    @else
        <div class="body-font fst-italic text-secondary mt-2">Notification source was deleted</div>
    @endif
</div>
