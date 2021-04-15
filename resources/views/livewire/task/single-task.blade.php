<span>
    <div class="align-items-center d-flex">
        <a href="{{ route('user.done', ['username' => $task->user->username]) }}">
            <img loading=lazy class="avatar-40 rounded-circle" src="{{ Helper::getCDNImage($task->user->avatar, 80) }}" height="40" width="40" alt="{{ $task->user->username }}'s avatar" />
        </a>
        <span class="ms-2">
            <a
                href="{{ route('user.done', ['username' => $task->user->username]) }}"
                class="fw-bold text-dark user-popover"
                data-id="{{ $task->user->id }}"
            >
                @if ($task->user->firstname or $task->user->lastname)
                    {{ $task->user->firstname }}{{ ' '.$task->user->lastname }}
                @else
                    {{ $task->user->username }}
                @endif
                @if ($task->user->status)
                <span class="ms-1 small" title="{{ $task->user->status }}">{{ $task->user->status_emoji }}</span>
                @endif
                @if ($task->user->isVerified)
                    <x-heroicon-s-badge-check class="heroicon ms-1 text-primary verified" />
                @endif
                @if ($task->user->isPatron)
                    <a class="patron" href="{{ route('patron.home') }}" aria-label="Patron">
                        <x-heroicon-s-star class="heroicon text-gold" />
                    </a>
                @endif
                <div class="small text-secondary fw-normal">{{ "@" . $task->user->username }}</div>
            </a>
        </span>
        <span class="align-text-top small float-end ms-auto text-secondary cursor-pointer" data-bs-toggle="collapse" data-bs-target="#taskExpand-{{$task->id}}" aria-expanded="false">
            {{ !$task->done_at ? $task->created_at->diffForHumans() : carbon($task->done_at)->diffForHumans() }}
        </span>
    </div>
    <div class="pt-3">
        @if ($task->hidden)
        <span class="task-font fst-italic text-secondary">Task was hidden by moderator</span>
        @else
        @if ($task->source === 'GitLab')
            <img class="task-icon" src="{{ asset('images/brand/gitlab.svg') }}" alt="GitHub Icon" />
        @elseif ($task->source === 'GitHub')
            <img class="task-icon github-logo" src="{{ asset('images/brand/github.svg') }}" alt="GitLab Icon" />
        @else
        <input
            class="form-check-input task-checkbox"
            id="task-{{ $task->id }}"
            type="checkbox"
            wire:click="checkTask"
            {{ $task->done ? "checked" : "unchecked" }}
            {{
                Auth::check() &&
                auth()->user()->id === $task->user_id ?
                "enabled" : "disabled"
            }}
        />
        @if ($launched)<span class="ms-1">🚀</span>@endif
        @endif
        <label for="task-{{ $task->id }}" class="ms-1 task-font d-inline @if ($launched) fw-bold text-success @endif">
            {!! Purify::clean(Helper::renderTask($task->task)) !!}
            @if ($task->type === 'product')
            <span class="small text-secondary">
                on
                <img loading=lazy class="rounded mb-1 ms-1 avatar-15" src="{{ Helper::getCDNImage($task->product->avatar, 80) }}" height="15" width="15" alt="{{ $task->product->slug }}'s avatar" />
                <a
                    class="text-secondary product-popover"
                    href="{{ route('product.done', ['slug' => $task->product->slug]) }}"
                    data-id="{{ $task->product->id }}"
                >
                    {{ $task->product->name }}
                </a>
            </span>
            @endif
        </label>
        @if ($task->images)
        <div class="gallery">
        @foreach ($task->images ?? [] as $image)
        <div>
            <a href="{{ asset('storage/' . $image) }}" target="_blank">
                <img loading=lazy class="gallery img-fluid border mt-3 rounded" src="{{ Helper::getCDNImage(asset('storage/' . $image), 600) }}" alt="{{ asset('storage/' . $image) }}" />
            </a>
        </div>
        @endforeach
        </div>
        @endif
        @livewire('task.comments', [
            'task' => $task
        ])
        @endif
        <div class="pt-3">
            @auth
            @if (!$task->user->isPrivate and !$task->hidden)
            @if (auth()->user()->hasLiked($task))
            <button type="button" class="btn btn-task btn-success text-white me-1" wire:click="togglePraise" wire:loading.attr="disabled" wire:offline.attr="disabled" wire:key="{{ $task->id }}" aria-label="Praises">
                <x-heroicon-s-thumb-up class="heroicon-small me-0" />
                <span class="small text-white fw-bold">
                    {{ number_format($task->likerscount()) }}
                </span>
                <span class="avatar-stack ms-1">
                @foreach($task->likers->take(5) as $user)
                <img loading=lazy class="praise-avatar rounded-circle {{ $loop->last ? 'me-0' : '' }}" src="{{ Helper::getCDNImage($user->avatar, 80) }}" height="15" width="15" alt="{{ $user->username }}'s avatar" />
                @endforeach
                </span>
            </button>
            @else
            <button type="button" class="btn btn-task btn-outline-success me-1" wire:click="togglePraise" wire:loading.attr="disabled" wire:offline.attr="disabled" wire:key="{{ $task->id }}" aria-label="Praises">
                <x-heroicon-o-thumb-up class="heroicon-small me-0 text-secondary" />
                @if ($task->likerscount() !== 0)
                <span class="small text-dark fw-bold">
                    {{ number_format($task->likerscount()) }}
                </span>
                <span class="avatar-stack ms-1">
                @foreach($task->likers->take(5) as $user)
                <img loading=lazy class="praise-avatar rounded-circle {{ $loop->last ? 'me-0' : '' }}" src="{{ Helper::getCDNImage($user->avatar, 80) }}" height="15" width="15" alt="{{ $user->username }}'s avatar" />
                @endforeach
                </span>
                @endif
            </button>
            @endif
            @endif
            @endauth
            @guest
                <a href="/login" class="btn btn-task btn-outline-success me-1" aria-label="Praises">
                    <x-heroicon-o-thumb-up class="heroicon-small me-0 text-secondary" />
                    @if ($task->likerscount() !== 0)
                    <span class="small text-dark fw-bold">
                        {{ number_format($task->likerscount()) }}
                    </span>
                    <span class="avatar-stack ms-1">
                    @foreach($task->likers->take(5) as $user)
                    <img loading=lazy class="praise-avatar rounded-circle {{ $loop->last ? 'me-0' : '' }}" src="{{ Helper::getCDNImage($user->avatar, 80) }}" height="15" width="15" alt="{{ $user->username }}'s avatar" />
                    @endforeach
                    </span>
                    @endif
                </a>
            @endguest
            <a href="{{ route('task', ['id' => $task->id]) }}" class="btn btn-task btn-outline-primary me-1" aria-label="Comments">
                <x-heroicon-o-chat-alt class="heroicon-small me-0 text-secondary" />
                @if ($task->comments->count('id') !== 0)
                <span class="small text-dark fw-bold">
                    {{ number_format($task->comments->count('id')) }}
                </span>
                @endif
            </a>
            @auth
            @if (auth()->user()->staffShip or auth()->user()->id === $task->user->id)
                @if ($confirming === $task->id)
                <button type="button" class="btn btn-task btn-danger" wire:click="deleteTask" wire:loading.attr="disabled" wire:offline.attr="disabled" aria-label="Confirm Delete">
                    Are you sure?
                </button>
                @else
                <button type="button" class="btn btn-task btn-outline-danger" wire:click="confirmDelete" wire:loading.attr="disabled" wire:offline.attr="disabled" aria-label="Delete">
                    <x-heroicon-o-trash class="heroicon-small me-0 text-secondary" />
                </button>
                @endif
            @endif
            @if (auth()->user()->staffShip)
            <button type="button" class="btn btn-task {{ $task->hidden ? 'btn-info' : 'btn-outline-info' }} ms-1" wire:click="hide" wire:loading.attr="disabled" wire:offline.attr="disabled" wire:key="{{ $task->id }}" title="Flag to admins" aria-label="Hide">
                <x-heroicon-o-eye-off class="heroicon-small me-0" />
            </button>
            @endif
            @endauth
        </div>
    </div>
    <div class="collapse mt-3 text-secondary" id="taskExpand-{{$task->id}}">
        <a class="text-secondary" href="{{ route('task', ['id' => $task->id]) }}">
            <x-heroicon-o-calendar class="heroicon-small" />
            @auth
            {{
                !$task->done_at ?
                    carbon($task->created_at)
                        ->setTimezone(auth()->user()->timezone)
                        ->format('g:i A · M d, Y') :
                    carbon($task->done_at)
                        ->setTimezone(auth()->user()->timezone)
                        ->format('g:i A · M d, Y')
            }}
            @else
            {{
                !$task->done_at ?
                    $task->created_at->format('g:i A · M d, Y') :
                    carbon($task->done_at)->format('g:i A · M d, Y')
            }}
            @endauth
            · via
            <span class="fw-bold">{{ $task->source }}</span>
        </a>
    </div>
</span>
