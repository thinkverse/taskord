<div class="card-body">
    <div class="align-items-center d-flex mb-2">
        <x:shared.user-label-small :user="$answer->user" />
        <span class="align-text-top small float-end ms-auto">
            <a class="text-secondary" href="">
                {{ carbon($answer->created_at)->diffForHumans() }}
            </a>
        </span>
    </div>
    @if ($answer->hidden)
        <span class="body-font fst-italic text-secondary">Answer was hidden by moderator</span>
    @else
        <div class="body-font">
            {!! markdown($answer->answer) !!}
        </div>
    @endif
    <div class="mt-2">
        @auth
            @if (auth()->user()->hasLiked($answer))
                <button type="button" class="btn btn-task btn-praise text-white me-1" wire:click="togglePraise" wire:loading.attr="disabled" wire:offline.attr="disabled" aria-label="Praise">
                    <span wire:loading wire:target="togglePraise" class="spinner-border spinner-border-task" role="status"></span>
                    <x-heroicon-s-heart wire:loading.remove wire:target="togglePraise" class="heroicon heroicon-15px me-0" />
                    <span class="small fw-bold">
                        {{ number_format($answer->likerscount()) }}
                    </span>
                    <span class="avatar-stack ms-1">
                        @foreach($answer->likers->take(5) as $user)
                            <img loading=lazy class="praise-avatar rounded-circle {{ $loop->last ? 'me-0' : '' }}" src="{{ Helper::getCDNImage($user->avatar, 80) }}" height="15" width="15" alt="{{ $user->username }}'s avatar" />
                        @endforeach
                    </span>
                </button>
            @else
                <button type="button" class="btn btn-task btn-outline-praise me-1" wire:click="togglePraise" wire:loading.attr="disabled" wire:offline.attr="disabled" aria-label="Praises">
                    <span wire:loading wire:target="togglePraise" class="spinner-border spinner-border-task" role="status"></span>
                    <x-heroicon-o-heart wire:loading.remove wire:target="togglePraise" class="heroicon heroicon-15px me-0" />
                    @if ($answer->likerscount() !== 0)
                        <span class="small fw-bold">
                            {{ number_format($answer->likerscount()) }}
                        </span>
                        <span class="avatar-stack ms-1">
                            @foreach($answer->likers->take(5) as $user)
                                <img loading=lazy class="praise-avatar rounded-circle {{ $loop->last ? 'me-0' : '' }}" src="{{ Helper::getCDNImage($user->avatar, 80) }}" height="15" width="15" alt="{{ $user->username }}'s avatar" />
                            @endforeach
                        </span>
                    @endif
                </button>
            @endif
            @can('edit/delete', $answer)
                <button
                    type="button"
                    class="btn btn-task btn-outline-danger"
                    onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
                    wire:click="deleteAnswer"
                    wire:loading.attr="disabled"
                    wire:offline.attr="disabled"
                    aria-label="Delete"
                >
                    <x-heroicon-o-trash class="heroicon heroicon-15px me-0 text-secondary" />
                </button>
            @endcan
            @can('staff.ops')
                <button type="button" class="btn btn-task {{ $answer->hidden ? 'btn-info' : 'btn-outline-info' }} ms-1" wire:click="hide" wire:loading.attr="disabled" wire:offline.attr="disabled" wire:key="{{ $answer->id }}" aria-label="Hide">
                    <x-heroicon-o-eye-off class="heroicon heroicon-15px me-0" />
                </button>
            @endcan
        @endauth
        @guest
            <a href="/login" class="btn btn-task btn-outline-praise me-1" aria-label="Praises">
                <x-heroicon-o-heart class="heroicon heroicon-15px me-0" />
                @if ($answer->likerscount() !== 0)
                    <span class="small fw-bold">
                        {{ number_format($answer->likerscount()) }}
                    </span>
                    <span class="avatar-stack ms-1">
                        @foreach($answer->likers->take(5) as $user)
                            <img loading=lazy class="praise-avatar rounded-circle {{ $loop->last ? 'me-0' : '' }}" src="{{ Helper::getCDNImage($user->avatar, 80) }}" height="15" width="15" alt="{{ $user->username }}'s avatar" />
                        @endforeach
                    </span>
                @endif
            </a>
        @endguest
    </div>
</div>
