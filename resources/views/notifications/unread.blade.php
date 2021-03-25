@extends('layouts.app')

@section('pageTitle', 'Notifications ·')

@section('content')
<div class="container-md">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <a role="button" class="btn btn-primary mb-3 me-2" href="{{ route('notifications.unread') }}">
                Unread
                <span class="ms-1 badge bg-white text-secondary">
                    {{ auth()->user()->unreadNotifications->count('id') }}
                </span>
            </a>
            <a role="button" class="btn btn-primary mb-3" href="{{ route('notifications.all') }}">
                All
            </a>
            @if (auth()->user()->unreadNotifications->count('id') !== 0)
            @livewire('notification.mark-as-read')
            @endif
            @livewire('notification.unread', [
                'type' => 'unread',
                'page' => 1,
                'perPage' => 10
            ])
        </div>
    </div>
</div>
@endsection
