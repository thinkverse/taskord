@extends('layouts.app')

@section('pageTitle', 'Admin - Users ·')
@section('title', 'Admin - Users ·')
@section('description', 'Get things done socially with Taskord.')
@section('image', '')
@section('url', url()->current())

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="container">
            @include('admin.nav')
            <div class="card">
                <div class="card-header">
                    <span class="h5">Users</span>
                    <div>{{ $count }} total users</div>
                </div>
                <div class="table-responsive">
                    <table class="table text-dark">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Avatar</th>
                                <th scope="col">Name</th>
                                <th scope="col">Username</th>
                                <th scope="col">Email</th>
                                <th scope="col">Patron</th>
                                <th scope="col">Last IP</th>
                                <th scope="col">Via</th>
                                <th scope="col">Created</th>
                                <th scope="col">Last updated</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <th>{{ $user->id }}</th>
                                <td>
                                    <img class="avatar-30 rounded-circle mr-2" src="{{ $user->avatar }}" />
                                </td>
                                <td class="font-weight-bold">
                                    {{ $user->firstname.' '.$user->lastname }}
                                </td>
                                <td>
                                    <a href="{{ route('user.done', ['username' => $user->username]) }}" target="_blank">
                                        {{ '@'.$user->username }}
                                    </a>
                                </td>
                                <td>
                                    {{ $user->email }}
                                    @if ($user->hasVerifiedEmail())
                                    <i class="fa fa-check text-success ml-1" title="Email Verified"></i>
                                    @else
                                    <i class="fa fa-times text-danger ml-1" title="Email not Verified"></i>
                                    @endif
                                </td>
                                <td>
                                    @if (!$user->isPatron)
                                    <span>
                                        ❌
                                    </span>
                                    @else
                                    <span>
                                        💰
                                        @if ($user->patron)
                                        🤝
                                        @else
                                        🎁
                                        @endif
                                    </span>
                                    @endif
                                </td>
                                <td>
                                    @if ($user->lastIP)
                                    <a class="font-monospace" href="https://ipinfo.io/{{ $user->lastIP }}" title="{{ $user->lastIP }}" target="_blank">
                                        {{ Str::limit($user->lastIP, 15, '..') }}
                                    </a>
                                    @else
                                    <span class="small font-weight-bold text-black-50">Not logged</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($user->provider === 'google')
                                        <i class="fa fa-google text-danger"></i>
                                    @elseif ($user->provider === 'twitter')
                                        <i class="fa fa-twitter text-info"></i>
                                    @else
                                        <i class="fa fa-globe text-success"></i>
                                    @endif
                                </td>
                                <td title="{{ Carbon::parse($user->created_at)->format('M d, Y g:i A') }}">
                                    {{ Carbon::parse($user->created_at)->format('M d, Y') }}
                                    @if ($user->created_at->diffInDays(Carbon::today()) < 7)
                                        🆕
                                    @endif
                                </td>
                                <td title="{{ Carbon::parse($user->updated_at)->format('M d, Y g:i A') }}">
                                    {{ Carbon::parse($user->updated_at)->diffForHumans() }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
