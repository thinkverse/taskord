<div>
    @php
        $user = \App\Models\User::find($data['user_id']);
        if (!$user) {
            $user = \App\Models\User::where('username', 'ghost')->first();
        }
    @endphp
    <div class="card mb-3">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                @if ($type !== "App\Notifications\Welcome" and $type !== "App\Notifications\VersionReleased")
                    <x:shared.user-label-small :user="$user" />
                @endif
                @if ($page_type === 'unread')
                    <button wire:click="markSingleNotificationAsRead" class="btn btn-sm btn-task ms-5" title="Mark as read">
                        <span wire:loading.remove>
                            <x-heroicon-s-check class="heroicon heroicon-2x text-secondary me-0" />
                        </span>
                        <span wire:loading class="spinner-border spinner-border-sm"></span>
                    </button>
                @endif
            </div>
            @if ($type === "App\Notifications\TaskPraised")
                <livewire:notification.type.task.task-praised :data="$data" />
            @elseif ($type === "App\Notifications\Mentioned")
                <livewire:notification.type.mentioned :data="$data" />
            @elseif ($type === "App\Notifications\CommentPraised")
                <livewire:notification.type.comment.comment-praised :data="$data" />
            @elseif ($type === "App\Notifications\QuestionPraised")
                <livewire:notification.type.question.question-praised :data="$data" />
            @elseif ($type === "App\Notifications\AnswerPraised")
                <livewire:notification.type.answer.answer-praised :data="$data" />
            @elseif ($type === "App\Notifications\Commented")
                <livewire:notification.type.comment.commented :data="$data" />
            @elseif ($type === "App\Notifications\Answered")
                <livewire:notification.type.answer.answered :data="$data" />
            @elseif ($type === "App\Notifications\Subscribed")
                <livewire:notification.type.product.subscribed :data="$data" />
            @elseif ($type === "App\Notifications\Product\MemberAdded")
                <livewire:notification.type.product.member-added :data="$data" />
            @elseif ($type === "App\Notifications\Product\MemberRemoved")
                <livewire:notification.type.product.member-removed :data="$data" />
            @elseif ($type === "App\Notifications\Product\MemberLeft")
                <livewire:notification.type.product.member-left :data="$data" />
            @elseif ($type === "App\Notifications\Task\NotifySubscribers")
                <livewire:notification.type.task.notify-subscribers :data="$data" />
            @elseif ($type === "App\Notifications\Question\NotifySubscribers")
                <livewire:notification.type.question.notify-subscribers :data="$data" />
            @elseif ($type === "App\Notifications\Followed")
                <div class="mt-2 text-secondary">
                    followed you
                </div>
                <div class="mt-2">
                    @livewire('notification.follow', [
                        'user' => $user
                    ])
                </div>
            @elseif ($type === "App\Notifications\Welcome")
                <div class="mt-2 fw-bold">
                    Welcome to Taskord! 👋
                </div>
                <div class="mt-2">
                    <a href="{{ route('explore.explore') }}">Explore</a> what's happening on Taskord
                </div>
                <div class="mt-2">
                    Have a nice day 💜
                </div>
            @elseif ($type === "App\Notifications\VersionReleased")
                <div class="mt-2 fw-bold">
                    Version {{ $data['tagName'] }} has been released!
                </div>
                <div class="mt-3">
                    <span class="fw-bold">Changelog</span>
                    <div class="mt-2">
                        {!! markdown($data['description']) !!}
                    </div>
                </div>
            @endif
            <div class="small mt-3 text-secondary">
                {{ carbon($created_at)->diffForHumans() }}
            </div>
        </div>
    </div>
</div>
