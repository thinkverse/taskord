<div class="card mb-2 {{ $question->patronOnly ? 'bg-patron' : '' }}">
    <div class="card-body">
        <div class="d-flex align-items-center">
            <x:shared.user-label-big :user="$question->user" />
            <span class="align-text-top small float-end ms-auto">
                <a class="text-secondary" href="{{ route('question.question', ['id' => $question->id]) }}">
                    {{ $question->created_at->diffForHumans() }}
                </a>
            </span>
        </div>
    </div>
    <div class="card-body pt-1">
        @if ($question->hidden)
            <span class="fst-italic text-secondary">Question was hidden by moderator</span>
        @else
        <a href="{{ route('question.question', ['id' => $question->id]) }}" class="h5 align-text-top fw-bold text-dark">
            @if ($type !== "question.question")
                {{ Str::words($question->title, '10') }}
            @else
                {{ $question->title }}
            @endif
        </a>
        <div class="mt-2 body-font">
            @if ($type !== "question.question")
                @if (!$question->patronOnly)
                    {!! markdown(Str::words($question->body, '30')) !!}
                @endif
            @else
                {!! markdown($question->body) !!}
            @endif
        </div>
        @endif
        <div class="mt-3">
            @auth
                @if (auth()->user()->hasLiked($question))
                    <button role="button" class="btn btn-task btn-success text-white me-1" wire:click="togglePraise" wire:loading.attr="disabled" wire:offline.attr="disabled" aria-label="Praises">
                        <x-heroicon-s-thumb-up class="heroicon-small me-0" />
                        <span class="small text-white fw-bold">
                            {{ number_format($question->likerscount()) }}
                        </span>
                        <span class="avatar-stack ms-1">
                            @foreach($question->likers->take(5) as $user)
                                <img loading=lazy class="praise-avatar rounded-circle {{ $loop->last ? 'me-0' : '' }}" src="{{ Helper::getCDNImage($user->avatar, 80) }}" height="15" width="15" alt="{{ $user->username }}'s avatar" />
                            @endforeach
                        </span>
                    </button>
                @else
                    <button role="button" class="btn btn-task btn-outline-success me-1" wire:click="togglePraise" wire:loading.attr="disabled" wire:offline.attr="disabled" aria-label="Praises">
                        <x-heroicon-o-thumb-up class="heroicon-small me-0 text-secondary" />
                        @if ($question->likerscount() !== 0)
                            <span class="small text-dark fw-bold">
                                {{ number_format($question->likerscount()) }}
                            </span>
                            <span class="avatar-stack ms-1">
                                @foreach($question->likers->take(5) as $user)
                                    <img loading=lazy class="praise-avatar rounded-circle {{ $loop->last ? 'me-0' : '' }}" src="{{ Helper::getCDNImage($user->avatar, 80) }}" height="15" width="15" alt="{{ $user->username }}'s avatar" />
                                @endforeach
                            </span>
                        @endif
                    </button>
                @endif
                <a href="{{ route('question.question', ['id' => $question->id]) }}" class="btn btn-task btn-outline-primary me-1" aria-label="Questions">
                    <x-heroicon-o-chat-alt class="heroicon-small me-0 text-secondary" />
                    @if ($question->answer->count('id') !== 0)
                        <span class="small text-dark fw-bold">
                            {{ number_format($question->answer->count('id')) }}
                        </span>
                    @endif
                </a>
                @if (auth()->user()->staffShip or auth()->user()->id === $question->user->id)
                    @if ($type === "question.question")
                        <a href="{{ route('question.edit', ['question' => $question]) }}" class="btn btn-task btn-outline-info me-1">
                            <x-heroicon-o-pencil-alt class="heroicon-small me-0 text-secondary" />
                            <span class="small text-dark fw-bold">
                                Edit
                            </span>
                        </a>
                    @endif
                    <button
                        role="button"
                        class="btn btn-task btn-outline-danger me-1"
                        onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
                        wire:click="deleteQuestion"
                        wire:loading.attr="disabled"
                        wire:offline.attr="disabled"
                        aria-label="Delete"
                    >
                        <x-heroicon-o-trash class="heroicon-small me-0 text-secondary" />
                    </button>
                @endif
                @if (auth()->user()->staffShip)
                    <button type="button" class="btn btn-task {{ $question->hidden ? 'btn-info' : 'btn-outline-info' }}" wire:click="hide" wire:loading.attr="disabled" wire:offline.attr="disabled" wire:key="{{ $question->id }}" title="Flag to admins" aria-label="Hide">
                        <x-heroicon-o-eye-off class="heroicon-small me-0" />
                    </button>
                @endif
            @endauth
            @guest
                <a href="/login" class="btn btn-task btn-outline-success me-1" aria-label="Praises">
                    <x-heroicon-o-thumb-up class="heroicon-small me-0 text-secondary" />
                    @if ($question->likerscount() !== 0)
                        <span class="small text-dark fw-bold">
                            {{ number_format($question->likerscount()) }}
                        </span>
                        <span class="avatar-stack ms-1">
                            @foreach($question->likers->take(5) as $user)
                                <img loading=lazy class="praise-avatar rounded-circle {{ $loop->last ? 'me-0' : '' }}" src="{{ Helper::getCDNImage($user->avatar, 80) }}" height="15" width="15" alt="{{ $user->username }}'s avatar" />
                            @endforeach
                        </span>
                    @endif
                </a>
            @endguest
            @if (views($question)->remember(now()->addHours(6))->count('id') > 0)
                <span class="align-middle ms-2 me-2">
                    <x-heroicon-o-eye class="heroicon" />
                    <span class="text-secondary">
                        @php
                            $views = views($question)->remember(now()->addHours(6))->unique()->count('id')
                        @endphp
                        <span class="fw-bold">{{ number_format($views) }}</span>
                        {{ str_plural('View', $views) }}
                    </span>
                </span>
            @endif
            @if ($type !== "question.question")
                <a href="{{ route('question.question', ['id' => $question->id]) }}" class="avatar-stack text-dark">
                    @foreach ($question->answer->groupBy('user_id')->take(5) as $answer)
                        <img
                            loading=lazy
                            class="user-popover rounded-circle avatar avatar-30"
                            data-id="{{ $answer[0]->user->id }}"
                            src="{{ Helper::getCDNImage($answer[0]->user->avatar, 80) }}"
                            height="30" width="30"
                            alt="{{ $answer[0]->user->username }}'s avatar"
                        />
                    @endforeach
                    @if ($question->answer->groupBy('user_id')->count('id') >= 5)
                        <span class="ms-3 ps-1 align-middle fw-bold small">
                            +{{ number_format($question->answer->groupBy('user_id')->count('id') - 5) }} more
                        </span>
                    @endif
                </a>
            @endif
        </div>
    </div>
</div>
