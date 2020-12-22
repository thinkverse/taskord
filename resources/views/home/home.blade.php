@extends('layouts.app')

@section('description', 'Get things done socially with Taskord.')
@section('image', 'https://i.imgur.com/AcK2WpZ.png')
@section('url', url()->current())

@section('content')
<div class="container-md">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            @guest
            <div class="p-5 rounded mb-4 text-white welcome-card">
                <h1>Welcome to Taskord 👋</h1>
                <p class="lead">
                    <span class="fw-bold">Don't fake just make!</span> Get things done in public with awesome community of makers.
                </p>
                <a class="btn btn-lg btn-light" href="/register" role="button">
                    Signup now
                </a>
            </div>
            @endguest
            <div class="pb-2 h5">
                <x-heroicon-o-chat-alt-2 class="heroicon-2x ms-1 text-secondary" />
                Recent questions
            </div>
            <div class="card mb-4">
                <div class="card-body">
                    @foreach ($recent_questions as $question)
                        <div class="{{ $loop->index === count($recent_questions) - 1 ? '' : 'mb-2' }} {{ $question->patronOnly ? 'bg-patron recent-questions' : '' }} d-flex align-items-center">
                            <a
                                href="{{ route('user.done', ['username' => $question->user->username]) }}"
                                class="user-popover"
                                data-id="{{ $question->user->id }}"
                            >
                                <img loading=lazy class="rounded-circle avatar-30" src="{{ Helper::getCDNImage($question->user->avatar, 80) }}" alt="{{ $question->user->username }}'s avatar" />
                            </a>
                            <div class="ms-3">
                                <a href="{{ route('question.question', ['id' => $question->id]) }}" class="align-middle text-dark fw-bold">{{ Str::words($question->title, '10') }}</a>
                                @if ($question->created_at->isToday())
                                <span class="badge bg-success ms-2 align-middle">New</span>
                                @endif
                                <div>
                                    <a
                                        href="{{ route('user.done', ['username' => $question->user->username]) }}"
                                        data-id="{{ $question->user->id }}"
                                        class="user-popover text-secondary"
                                    >
                                        by {{ '@'.$question->user->username }}
                                    </a>
                                    @if ($question->answer->count('id') >= 1)
                                    <span class="ms-1 text-secondary">
                                        · {{ $question->answer->count('id') }} {{ $question->answer->count('id') >= 1 ? 'answers' : 'answer' }}
                                    </span>
                                    @endif
                                    <span class="avatar-stack ms-1">
                                        @foreach ($question->answer->groupBy('user_id')->take(5) as $answer)
                                        <img
                                            loading=lazy
                                            class="user-popover replies-avatar rounded-circle {{ $loop->last ? 'me-0' : '' }}"
                                            data-id="{{ $answer[0]->user->id }}"
                                            src="{{ Helper::getCDNImage($answer[0]->user->avatar, 80) }}"
                                            alt="{{ $answer[0]->user->username }}'s avatar"
                                        />
                                        @endforeach
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @if (count($launched_today) > 0)
            <div class="pb-2 h5">
                <x-heroicon-o-lightning-bolt class="heroicon-2x ms-1 text-secondary" />
                Launched Today
            </div>
            <div class="card mb-4">
                <ul class="list-group list-group-flush">
                    @foreach ($launched_today->take(5) as $product)
                    <li class="list-group-item">
                        <div class="d-flex align-items-center">
                            <a href="{{ route('product.done', ['slug' => $product->slug]) }}">
                                <img loading=lazy class="rounded avatar-50 mt-1 ms-2" src="{{ Helper::getCDNImage($product->avatar, 160) }}" alt="{{ $product->slug }}'s avatar" height="50" width="50" />
                            </a>
                            <span class="ms-3">
                                <a href="{{ route('product.done', ['slug' => $product->slug]) }}" class="me-2 h5 align-text-top fw-bold text-dark">
                                    {{ $product->name }}
                                    @if ($product->launched)
                                        <a href="{{ route('products.launched') }}" class="small" data-bs-toggle="tooltip" data-placement="right" title="Launched">
                                            🚀
                                        </a>
                                    @endif
                                </a>
                                <div>{{ $product->description }}</div>
                            </span>
                            <span class="ms-auto">
                                @if ($product->members()->count() > 1)
                                    <span class="me-2 mt-1 text-secondary fw-bold">+{{ $product->members()->count() - 1 }} more</span>
                                @endif
                                @foreach ($product->members()->limit(1)->get() as $user)
                                <a
                                    href="{{ route('user.done', ['username' => $user->username]) }}"
                                    class="user-popover"
                                    data-id="{{ $user->id }}"
                                >
                                    <img loading=lazy class="rounded-circle avatar-30 mt-1 me-1" src="{{ Helper::getCDNImage($user->avatar, 80) }}" alt="{{ $user->username }}'s avatar" />
                                </a>
                                @endforeach
                                <a
                                    href="{{ route('user.done', ['username' => $product->owner->username]) }}"
                                    class="user-popover"
                                    data-id="{{ $product->owner->id }}"
                                >
                                    <img loading=lazy class="rounded-circle avatar-30 mt-1 me-0" src="{{ Helper::getCDNImage($product->owner->avatar, 80) }}" alt="{{ $product->owner->username }}'s avatar" />
                                </a>
                            </span>
                        </div>
                    </li>
                    @endforeach
                </ul>
                @if (count($launched_today) > 5)
                <div class="card-footer">
                    <a class="fw-bold" href="{{ route('products.newest') }}">More Products...</a>
                </div>
                @endif
            </div>
            @endif
            @auth
                @if (!Auth::user()->isFlagged)
                @livewire('create-task')
                @endif
            @endauth
            <div class="pb-3">
                <span class="h5">
                    <x-heroicon-o-check-circle class="heroicon-2x ms-1 text-secondary" />
                    Tasks
                </span>
                @auth
                @livewire('home.only-following')
                @endauth
            </div>
            @livewire('home.tasks', [
                'page' => 1,
            ])
        </div>
        <div class="col-sm">
            @auth
                @livewire('home.onboarding')
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <a href="{{ route('user.done', ['username' => Auth::user()->username]) }}">
                                <img loading=lazy class="rounded-circle avatar-50 mt-1" src="{{ Helper::getCDNImage(Auth::user()->avatar, 160) }}" alt="{{ Auth::user()->username }}'s avatar" />
                            </a>
                            <a class="ms-3 text-dark" href="{{ route('user.done', ['username' => Auth::user()->username]) }}">
                                @if (Auth::user()->firstname or Auth::user()->lastname)
                                <div class="h5">
                                    {{ Auth::user()->firstname }}{{ ' '.Auth::user()->lastname }}
                                    @if (Auth::user()->isVerified)
                                        <x-heroicon-s-badge-check class="heroicon-2x ms-1 text-primary verified" />
                                    @endif
                                </div>
                                @endif
                                <div class="small fw-bold">
                                    {{ '@'.Str::limit(Auth::user()->username, '20') }}
                                </div>
                            </a>
                            <a class="btn btn-sm btn-success text-white float-end ms-auto" href="{{ route('user.settings.profile') }}">
                                <x-heroicon-o-cog class="heroicon" />
                                Update
                            </a>
                        </div>
                    </div>
                    <div class="card-footer small fw-bold d-flex justify-content-between">
                        <a class="text-dark" href="{{ route('user.following', ['username' => Auth::user()->username]) }}">
                            <x-heroicon-o-user-add class="heroicon text-secondary" />
                            {{ Auth::user()->followings()->count() }}
                            Following
                        </a>
                        <a class="text-dark" href="{{ route('user.followers', ['username' => Auth::user()->username]) }}">
                            <x-heroicon-o-users class="heroicon text-secondary" />
                            {{ number_format(Auth::user()->followers()->count()) }}
                            {{ Auth::user()->followers()->count() === 1 ? "Follower" : "Followers" }}
                        </a>
                        <span>
                            <x-heroicon-o-fire class="heroicon text-secondary" />
                            {{ number_format(Auth::user()->getPoints()) }}
                            {{ Auth::user()->getPoints() < 2 ? 'Reputation' : 'Reputations' }}
                        </span>
                    </div>
                </div>
            @endauth
            <div class="text-uppercase fw-bold text-secondary pb-2">
                Recently Joined
            </div>
            <div class="card mb-4">
                <div class="pt-2 pb-2">
                @foreach ($recently_joined as $user)
                <div class="d-flex align-items-center py-1 px-3">
                    <a href="{{ route('user.done', ['username' => $user->username]) }}">
                        <img loading=lazy class="rounded-circle avatar-40 mt-1" src="{{ Helper::getCDNImage($user->avatar, 160) }}" alt="{{ $user->username }}'s avatar" />
                    </a>
                    <span class="ms-3">
                        <a href="{{ route('user.done', ['username' => $user->username]) }}" class="align-text-top text-dark">
                            <span class="fw-bold">
                                @if ($user->firstname or $user->lastname)
                                    {{ $user->firstname }}{{ ' '.$user->lastname }}
                                @else
                                    {{ $user->username }}
                                @endif
                                @if ($user->isVerified)
                                    <x-heroicon-s-badge-check class="heroicon ms-1 text-primary verified" />
                                @endif
                            </span>
                            <div>
                                @if ($user->bio)
                                <span class="small">
                                    {{ $user->bio }}
                                </span>
                                @else
                                <span class="small text-secondary">
                                    Joined {{ Carbon::parse($user->created_at)->diffForHumans() }}
                                </span>
                                @endif
                            </div>
                        </a>
                    </span>
                </div>
                @endforeach
                </div>
                @if ($recently_joined_count > 5)
                <div class="card-footer">
                    <span class="fw-bold">{{ $recently_joined_count - 5 }} more...</span>
                </div>
                @endif
            </div>
            <div class="text-uppercase fw-bold text-secondary pb-2">
                Recently Launched
            </div>
            <div class="card mb-4">
                <div class="pt-2 pb-2">
                @foreach ($products as $product)
                <div class="py-2 px-3">
                    <a
                        href="{{ route('product.done', ['slug' => $product->slug]) }}"
                        class="product-popover"
                        data-id="{{ $product->id }}"
                    >
                        <img loading=lazy class="rounded avatar-30" src="{{ Helper::getCDNImage($product->avatar, 160) }}" alt="{{ $product->slug }}'s avatar" height="50" width="50" />
                    </a>
                    <a
                        href="{{ route('product.done', ['slug' => $product->slug]) }}"
                        class="ms-2 me-2 align-text-top fw-bold text-dark product-popover"
                        data-id="{{ $product->id }}"
                    >
                        {{ $product->name }}
                        @if ($product->launched)
                            <a href="{{ route('products.launched') }}" class="small" data-bs-toggle="tooltip" data-placement="right" title="Launched">
                                🚀
                            </a>
                        @endif
                    </a>
                    <span class="float-end">
                        @foreach ($product->members()->limit(1)->get() as $user)
                        <a
                            href="{{ route('user.done', ['username' => $user->username]) }}"
                            class="user-popover"
                            data-id="{{ $user->id }}"
                        >
                            <img loading=lazy class="rounded-circle avatar-30 mt-1 me-1" src="{{ Helper::getCDNImage($user->avatar, 160) }}" alt="{{ $user->username }}'s avatar" />
                        </a>
                        @endforeach
                        <a
                            href="{{ route('user.done', ['username' => $product->owner->username]) }}"
                            class="user-popover"
                            data-id="{{ $product->owner->id }}"
                        >
                            <img loading=lazy class="rounded-circle avatar-30 mt-1 me-0" src="{{ Helper::getCDNImage($product->owner->avatar, 80) }}" alt="{{ $product->owner->username }}'s avatar" />
                        </a>
                    </span>
                </div>
                @endforeach
                </div>
                <div class="card-footer">
                    <a class="fw-bold" href="{{ route('products.newest') }}">More Products...</a>
                </div>
            </div>
            <div class="text-uppercase fw-bold text-secondary pb-2">
                Top Reputations
            </div>
            <div class="card mb-4">
                <div class="pt-2 pb-2">
                    @foreach ($reputations as $user)
                    <div class="py-2 px-3">
                        <span class="h6 text-secondary" style="vertical-align:sub">
                            @if ($loop->index === 0)
                            <span class="fw-bold" style="color:#38c172">
                            @elseif ($loop->index === 1)
                            <span class="fw-bold" style="color:#6a63ec">
                            @elseif ($loop->index === 2)
                            <span class="fw-bold" style="color:#fd5f60">
                            @else
                            <span>
                            @endif
                                #{{ $loop->index + 1 }}
                            </span>
                        </span>
                        <a
                            href="{{ route('user.done', ['username' => $user->username]) }}"
                            class="user-popover"
                            data-id="{{ $user->id }}"
                        >
                            <img loading=lazy class="rounded-circle avatar-30 mt-1 ms-2" src="{{ Helper::getCDNImage($user->avatar, 80) }}" height="50" width="50" alt="{{ $user->username }}'s avatar" />
                        </a>
                        <a
                            href="{{ route('user.done', ['username' => $user->username]) }}"
                            class="ms-2 me-2 align-text-top fw-bold text-dark user-popover"
                            data-id="{{ $user->id }}"
                        >
                            @if ($user->firstname or $user->lastname)
                                {{ $user->firstname }}{{ ' '.$user->lastname }}
                            @else
                                {{ $user->username }}
                            @endif
                            @if ($user->isVerified)
                                <x-heroicon-s-badge-check class="heroicon ms-1 text-primary verified" />
                            @endif
                        </a>
                        <span class="badge rounded-pill bg-warning text-dark align-middle reputation" title="🔥 {{ number_format($user->getPoints()) }}">
                            🔥 {{ $user->getPoints(true) }}
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>
            <x-footer />
        </div>
    </div>
</div>
@endsection
