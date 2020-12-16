<div class="card">
    @auth
    @if (Auth::user()->isStaff && $user->isFlagged)
        <div class="p-4 pb-0">
            <div class="alert alert-danger alert-dismissible">
                This user is flagged
                {{ $user->isSuspended ? 'and suspended' : '' }}
                as spammy!
            </div>
        </div>
    @endif
    @endauth
    <div class="row">
        <div class="col-md-7">
            <div class="card-body d-flex align-items-center">
                <a href="{{ $user->avatar }}" data-lightbox="{{ $user->avatar }}" data-title="{{ '@'.$user->username }}'s Avatar">
                    <img class="rounded-circle avatar-120" src="{{ $user->avatar }}" />
                </a>
                <div class="ms-4">
                    <div class="h5 mb-0">
                        @if ($user->firstname or $user->lastname)
                            {{ $user->firstname }}{{ ' '.$user->lastname }}
                        @else
                            {{ $user->username }}
                        @endif
                        @auth
                        @endauth
                        @if ($user->isPrivate)
                            <i class="private ms-2 fa fa-lock text-primary"></i>
                        @endif
                        @if ($user->isVerified)
                            <i class="verified ms-2 fa fa-check-circle text-primary"></i>
                        @endif
                        @if ($user->isPatron)
                            <a class="patron ms-2 small" href="{{ route('patron.home') }}">
                                {{ Emoji::handshake() }}
                            </a>
                        @endif
                        @auth
                        @if ($user->isFollowing(Auth::user()))
                            <span class="ms-2 badge bg-light text-secondary">Follows you</span>
                        @endif
                        @if (Auth::user()->staffShip)
                            <span class="ms-2 text-secondary small">#{{ $user->id }}</span>
                        @endif
                        @endauth
                    </div>
                    <div class="text-black-50 mb-2">
                        {{ "@" . $user->username }}
                    </div>
                    @livewire('user.follow', [
                        'user' => $user
                    ])
                    @if ($user->bio)
                    <div class="mt-3">
                        {{ $user->bio }}
                    </div>
                    @endif
                    <div class="small mt-3">
                        <span>
                            <i class="fa fa-calendar-alt me-1 text-black-50"></i>
                            Joined {{ Carbon::parse($user->created_at)->format("F Y") }}
                        </span>
                        @if ($user->location)
                        <span class="ms-3">
                            <a class="text-dark" target="_blank" rel="noreferrer" href="https://www.google.com/maps/search/{{ urlencode($user->location) }}">
                                <i class="fa fa-compass me-1 text-black-50"></i>
                                {{ $user->location }}
                            </a>
                        </span>
                        @endif
                        @if ($user->company)
                        <span class="ms-3">
                            <i class="fa fa-briefcase me-1 text-black-50"></i>
                            {{ $user->company }}
                        </span>
                        @if ($user->isStaff)
                        <span class="badge rounded-pill bg-primary ms-1">Staff</span>
                        @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm">
            <div class="card-body">
                <div class="h5">Highlights</div>
                <div class="mt-3">
                    <div>
                        <span class="fw-bold">{{ Emoji::fire() }} {{ number_format($user->getPoints()) }}</span>
                        {{ $user->getPoints(true) < 2 ? 'Reputation' : 'Reputations' }}
                    </div>
                    @if (Auth::check() && Auth::id() === $user->id)
                    <div class="mt-2">
                        <span>{{ Emoji::blossom() }} You are a</span>
                        <span class="fw-bold">{{ count($level) === 0 ? 'Beginner' : $level->last()->name }}</span>
                        <x-beta background="light" />
                    </div>
                    @else
                    <div class="mt-2">
                        <span>{{ Emoji::blossom() }} {{ $user->username }} is a</span>
                        <span class="fw-bold">{{ count($level) === 0 ? 'Beginner' : $level->last()->name }}</span>
                        <x-beta background="light" />
                    </div>
                    @endif
                    @if ($user->isBeta)
                    <div class="mt-2">
                        <span class="fw-bold">{{ Emoji::testTube() }} Beta Program Member</span>
                    </div>
                    @endif
                    @if ($user->isDeveloper)
                    <div class="mt-2">
                        <span class="fw-bold">{{ Emoji::checkBoxWithCheck() }} Taskord Contributor</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer text-muted">
        @if (
            !$user->isPrivate or
            Auth::id() === $user->id or
            Auth::check() && Auth::user()->staffShip
        )
        <a class="text-dark fw-bold me-4" href="{{ route('user.done', ['username' => $user->username]) }}">
            <span class="@if (Route::currentRouteName() === 'user.done') text-primary @endif">Done</span>
            <span class="small fw-normal text-black-50">{{ number_format($done_count) }}</span>
        </a>
        <a class="text-dark fw-bold me-4" href="{{ route('user.pending', ['username' => $user->username]) }}">
            <span class="@if (Route::currentRouteName() === 'user.pending') text-primary @endif">Pending</span>
            <span class="small fw-normal text-black-50">{{ number_format($pending_count) }}</span>
        </a>
        @endif
        <a class="text-dark fw-bold me-4" href="{{ route('user.products', ['username' => $user->username]) }}">
            <span class="@if (Route::currentRouteName() === 'user.products') text-primary @endif">Products</span>
            <span class="small fw-normal text-black-50">{{ number_format($product_count) }}</span>
        </a>
        <a class="text-dark fw-bold me-4" href="{{ route('user.questions', ['username' => $user->username]) }}">
            <span class="@if (Route::currentRouteName() === 'user.questions') text-primary @endif">Questions</span>
            <span class="small fw-normal text-black-50">{{ number_format($question_count) }}</span>
        </a>
        <a class="text-dark fw-bold me-4" href="{{ route('user.answers', ['username' => $user->username]) }}">
            <span class="@if (Route::currentRouteName() === 'user.answers') text-primary @endif">Answers</span>
            <span class="small fw-normal text-black-50">{{ number_format($answer_count) }}</span>
        </a>
    </div>
</div>
