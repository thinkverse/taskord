@extends('layouts.app')

@section('pageTitle', 'Explore ·')
@section('title', 'Explore ·')
@section('description', 'Get things done socially with Taskord.')
@section('image', 'https://ik.imagekit.io/taskordimg/cover_i8r6XmiSW.png')
@section('url', url()->current())

@section('content')
<ul class="nav nav-pills justify-content-center">
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
        <div class="col-lg-8">
            <x-bottom-footer />
        </div>
    </div>
</div>
@endsection
