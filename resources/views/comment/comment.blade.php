@extends('layouts.app')

@section('pageTitle', $comment->comment.' ·')
@section('title', 'Task by @'.$comment->user->username.' ·')
@section('description', $comment->comment)
@section('image', $comment->user->avatar)
@section('url', url()->current())

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <span class="p-3">
                @livewire('task.single-task', [
                    'task' => $task
                ], key($task->id))
                </span>
            </div>

            @auth
            @if (!Auth::user()->isFlagged)
                @livewire('comment.create-comment', [
                    'task' => $task
                ])
            @endif
            @endauth
            @guest
                <a href="/login" class="btn btn-block btn-success mt-4 text-white font-weight-bold">
                    {{ Emoji::wavingHand() }} Login or Signup to comment
                </a>
            @endguest
        </div>
        <div class="col-sm">
            <div class="card mb-4">
                <div class="card-header">
                    Created by
                </div>
                <div class="card-body d-flex align-items-center">
                    <a href="{{ route('user.done', ['username' => $comment->user->username]) }}">
                        <img class="rounded-circle avatar-40 mt-1" src="{{ $comment->user->avatar }}" />
                    </a>
                    <span class="ml-3">
                        <a href="{{ route('user.done', ['username' => $comment->user->username]) }}" class="align-text-top text-dark">
                            <span class="font-weight-bold">
                                @if ($comment->user->firstname or $comment->user->lastname)
                                    {{ $comment->user->firstname }}{{ ' '.$comment->user->lastname }}
                                @else
                                    {{ $comment->user->username }}
                                @endif
                            </span>
                            <div>{{ $comment->user->bio }}</div>
                        </a>
                    </span>
                </div>
            </div>
            @if ($comment->likerscount() > 0)
            <div class="card mb-4">
                <div class="card-header">
                    Liked by
                </div>
                <div class="card-body align-items-center pb-2">
                    @foreach ($comment->likers as $user)
                        <a
                            title="{{ $user->firstname ? $user->firstname . ' ' . $user->lastname : $user->username }}"
                            href="{{ route('user.done', ['username' => $user->username]) }}"
                            class="mr-1"
                        >
                            <img class="rounded-circle avatar-30 mb-2" src="{{ $user->avatar }}" />
                        </a>
                    @endforeach
                </div>
            </div>
            @endif
            <x-footer />
        </div>
    </div>
</div>
@endsection
