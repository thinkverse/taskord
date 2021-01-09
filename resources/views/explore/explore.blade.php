@extends('layouts.app')

@section('pageTitle', 'Explore ·')
@section('title', 'Explore ·')
@section('description', 'Get things done socially with Taskord.')
@section('image', 'https://ik.imagekit.io/taskordimg/cover_i8r6XmiSW.png')
@section('url', url()->current())

@section('content')
@include('explore.nav')
<div class="container-md">
    <div class="row justify-content-center">
        <div class="col-sm explore-user-card">
            @auth
                @livewire('explore.user')
            @else
            <div class="card">
                <div class="card-body d-grid text-center">
                    <div class="h5 text-secondary">
                        Join Takord today!
                    </div>
                    <a class="btn btn-success text-white mt-2" href="{{ route('login') }}">
                        <x-heroicon-o-logout class="heroicon" />
                        Login
                    </a>
                    <a class="btn btn-primary text-white mt-2" href="{{ route('register') }}">
                        <x-heroicon-o-user-add class="heroicon" />
                        Signup
                    </a>
                </div>
            </div>
            @endauth
        </div>
        <div class="col-lg-6 mt-4">
            <div class="pb-2 h5 text-secondary">
                Recent popular tasks
            </div>
            @livewire('explore.popular-tasks', [
                'page' => 1,
            ])
        </div>
        <div class="col-sm mt-4">
            @auth
            @livewire('home.suggestions', [
                'user' => auth()->user()
            ])
            @endauth
            <div class="card">
                <div class="card-body">
                    🚧
                </div>
            </div>
        </div>
        <x-bottom-footer />
    </div>
</div>
@endsection
