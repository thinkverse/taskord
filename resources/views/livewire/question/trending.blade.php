<div wire:init="loadTrending">
    <div class="text-uppercase fw-bold text-secondary pb-2">
        <x-heroicon-o-fire class="heroicon text-danger" />
        Trending
    </div>
    <div class="card mb-4">
        <div class="pt-2 pb-2">
            @if (!$readyToLoad)
                <div class="card-body">
                    <x:loaders.question-skeleton count="5" />
                </div>
            @else
                @foreach ($trending as $question)
                    <div class="d-flex align-items-center py-2 px-3">
                        <a href="{{ route('user.done', ['username' => $question->user->username]) }}"
                            class="user-popover" data-id="{{ $question->user->id }}">
                            <img loading=lazy class="rounded-circle avatar-30 me-3 float-end"
                                src="{{ Helper::getCDNImage($question->user->avatar, 80) }}" height="30" width="30"
                                alt="{{ $question->user->username }}'s avatar" />
                        </a>
                        <div>
                            <a href="{{ route('question.question', ['slug' => $question->slug]) }}"
                                class="align-text-top text-dark">
                                <span class="fw-bold">
                                    {{ Str::words($question->title, '10') }}
                                </span>
                            </a>
                            <div class="text-secondary small mt-1">
                                @php
                                    $views = views($question)
                                        ->remember(now()->addHours(6))
                                        ->unique()
                                        ->count('id');
                                @endphp
                                <x-heroicon-o-eye class="heroicon" />
                                <span class="fw-bold">{{ number_format($views) }}</span>
                                {{ pluralize('View', $views) }}
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
