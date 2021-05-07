@extends('layouts.app')

@section('pageTitle', 'About ·')
@section('title', 'About ·')
@section('description', 'Get things done socially with Taskord.')
@section('image', '')
@section('url', url()->current())

@section('content')
<div class="container-md">
    <div class="text-center my-5">
        <img class="mb-3" src="https://ik.imagekit.io/taskordimg/logo_8lLu9EPFa.svg" height="70" alt="Taskord Logo">
        <div class="h2">Get things done in public</div>
        <div>in Taskord</div>
    </div>
    <div class="container p-0">
        <div class="row">
            <div class="col-lg-6 order-lg-2 text-white"></div>
            <div class="col-lg-6 order-lg-1 my-auto">
                <h2>🚀 Ship things in public</h2>
                <p class="lead mb-0">When you use a theme created by Start Bootstrap, you know that the theme will look great on any device, whether it's a phone, tablet, or desktop the page will behave responsively!</p>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-lg-6 text-white"></div>
            <div class="col-lg-6 my-auto">
                <h2>Updated For Bootstrap 4</h2>
                <p class="lead mb-0">Newly improved, and full of great utility classes, Bootstrap 4 is leading the way in mobile responsive web development! All of the themes on Start Bootstrap are now using Bootstrap 4!</p>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-lg-6 order-lg-2 text-white"></div>
            <div class="col-lg-6 order-lg-1 my-auto">
                <h2>Easy to Use & Customize</h2>
                <p class="lead mb-0">
                    Landing Page is just HTML and CSS with a splash of SCSS for users who demand some deeper customization options. Out of the box, just add your content and images, and your new landing page will be ready to go!
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
