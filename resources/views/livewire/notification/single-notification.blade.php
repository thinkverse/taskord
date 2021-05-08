<div>
    @php
        $user = \App\Models\User::find($data['user_id']);
        if (!$user) {
            $user = \App\Models\User::where('username', 'ghost')->first();
        }
    @endphp
    <div class="card mb-3">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <span class="fw-bold">
                    @if (
                        $type === "App\Notifications\TaskPraised" or
                        $type === "App\Notifications\QuestionPraised" or
                        $type === "App\Notifications\AnswerPraised" or
                        $type === "App\Notifications\CommentPraised"
                    )
                        <x-heroicon-o-thumb-up class="heroicon-1x text-secondary me-0" />
                    @elseif ($type === "App\Notifications\Mentioned")
                        <x-heroicon-o-at-symbol class="heroicon-1x text-secondary me-0" />
                    @elseif (
                        $type === "App\Notifications\Followed" or
                        $type === "App\Notifications\Subscribed" or
                        $type === "App\Notifications\Product\MemberAdded"
                    )
                        <x-heroicon-o-user-add class="heroicon-1x text-secondary me-0" />
                    @elseif (
                        $type === "App\Notifications\Commented" or
                        $type === "App\Notifications\Answered" or
                        $type === "App\Notifications\Task\NotifySubscribers" or
                        $type === "App\Notifications\Question\NotifySubscribers"
                    )
                        <x-heroicon-o-chat-alt class="heroicon-1x text-secondary me-0" />
                    @elseif (
                        $type === "App\Notifications\Product\MemberRemoved" or
                        $type === "App\Notifications\Product\MemberLeft"
                    )
                        <x-heroicon-o-logout class="heroicon-1x text-secondary me-0" />
                    @elseif (
                        $type === "App\Notifications\Welcome" or
                        $type === "App\Notifications\VersionReleased"
                    )
                        🎉
                    @endif
                    @if ($type !== "App\Notifications\Welcome" and $type !== "App\Notifications\VersionReleased")
                    <a href="{{ route('user.done', ['username' => $user->username]) }}">
                        <img loading=lazy class="rounded-circle avatar-20 ms-2 me-1" src="{{ Helper::getCDNImage($user->avatar, 80) }}" height="20" width="20" alt="{{ $user->username }}'s avatar" />
                        <span class="align-middle">
                            @if ($user->firstname or $user->lastname)
                                {{ $user->firstname }}{{ ' '.$user->lastname }}
                            @else
                                {{ $user->username }}
                            @endif
                        </span>
                    </a>
                    @endif
                </span>
                @if ($type === "App\Notifications\TaskPraised")
                    <livewire:notification.type.task-praised :data="$data" />
                @elseif ($type === "App\Notifications\Mentioned")
                    <livewire:notification.type.mentioned :data="$data" />
                @elseif ($type === "App\Notifications\CommentPraised")
                    <livewire:notification.type.comment-praised :data="$data" />
                @elseif ($type === "App\Notifications\QuestionPraised")
                    <livewire:notification.type.question-praised :data="$data" />
                @elseif ($type === "App\Notifications\AnswerPraised")
                    <livewire:notification.type.answer-praised :data="$data" />
                @elseif ($type === "App\Notifications\Commented")
                    <livewire:notification.type.commented :data="$data" />
                @elseif ($type === "App\Notifications\Answered")
                    <livewire:notification.type.answered :data="$data" />
                @elseif ($type === "App\Notifications\Followed")
                    <span class="align-middle">followed you</span>
                    <div class="mt-2">
                        @livewire('notification.follow', [
                            'user' => $user
                        ])
                    </div>
                @elseif ($type === "App\Notifications\Subscribed")
                    <livewire:notification.type.product.subscribed :data="$data" />
                @elseif ($type === "App\Notifications\Product\MemberAdded")
                    <livewire:notification.type.product.member-added :data="$data" />
                @elseif ($type === "App\Notifications\Product\MemberRemoved")
                    <span class="align-middle">
                        removed you from the product
                        <a class="fw-bold" href="{{ route('product.done', ['slug' => \App\Models\Product::find($data['product_id'])->slug]) }}">
                            <img loading=lazy class="rounded avatar-20 ms-1 me-1" src="{{ Helper::getCDNImage(\App\Models\Product::find($data['product_id'])->avatar, 80) }}" height="20" width="20" />
                            {{ \App\Models\Product::find($data['product_id'])->name }}
                        </a>
                    </span>
                @elseif ($type === "App\Notifications\Product\MemberLeft")
                    <span class="align-middle">
                        left from the product
                        <a class="fw-bold" href="{{ route('product.done', ['slug' => \App\Models\Product::find($data['product_id'])->slug]) }}">
                            <img loading=lazy class="rounded avatar-20 ms-1 me-1" src="{{ Helper::getCDNImage(\App\Models\Product::find($data['product_id'])->avatar, 80) }}" height="20" width="20" />
                            {{ \App\Models\Product::find($data['product_id'])->name }}
                        </a>
                    </span>
                @elseif ($type === "App\Notifications\Welcome")
                    <span class="ms-1 fw-bold">
                        <span>Welcome to Taskord! 👋</span>
                        <div class="mt-3">
                            <a href="{{ route('explore.explore') }}">Explore</a> what's happening on Taskord
                        </div>
                        <div class="mt-3">
                            Have a nice day 💜
                        </div>
                    </span>
                @elseif ($type === "App\Notifications\VersionReleased")
                    <span class="ms-1 fw-bold">
                        Version {{ $data['tagName'] }} has been released!
                    </span>
                    <div class="mt-3">
                        <span class="fw-bold">Changelog</span>
                        <div class="mt-2">
                            {!! markdown($data['description']) !!}
                        </div>
                    </div>
                @elseif ($type === "App\Notifications\Task\NotifySubscribers")
                    <livewire:notification.type.task.notify-subscribers :data="$data" />
                @elseif ($type === "App\Notifications\Question\NotifySubscribers")
                    <livewire:notification.type.question.notify-subscribers :data="$data" />
                @endif
                <div class="small mt-2 text-secondary">
                    {{ carbon($created_at)->diffForHumans() }}
                </div>
            </div>
            @if ($page_type === 'unread')
            <div>
                <button wire:click="markSingleNotificationAsRead" class="btn btn-sm btn-task ps-5">
                    <span wire:loading.remove>
                        <x-heroicon-o-check class="heroicon-2x text-secondary me-0" />
                    </span>
                    <span wire:loading class="spinner-border spinner-border-sm"></span>
                </button>
            </div>
            @endif
        </div>
    </div>
</div>
