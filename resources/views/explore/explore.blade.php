@extends('layouts.app')

@section('pageTitle', 'Explore ·')
@section('title', 'Explore ·')
@section('description', 'Get things done socially with Taskord.')
@section('image', 'https://ik.imagekit.io/taskordimg/cover_i8r6XmiSW.png')
@section('url', url()->current())

@section('content')
<ul class="nav nav-pills justify-content-center explore-nav bg-white py-3">
    <li class="nav-item">
        <a class="nav-link active" href="{{ route('explore') }}">Explore</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">Makers</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">Products</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">Tasks</a>
    </li>
</ul>
<div class="container-md">
    <div class="row justify-content-center">
        <div class="col-sm explore-user-card">
            @auth
                @livewire('explore.user')
            @else
            Hi
            @endauth
        </div>
        <div class="col-lg-6 mt-4">
            <div class="card">
                <div class="card-body">
                    
                </div>
            </div>
        </div>
        <div class="col-sm mt-4">
            <div class="card">
                <div class="card-body">
                    
                </div>
            </div>
        </div>
        <x-bottom-footer />
    </div>
</div>
@endsection
