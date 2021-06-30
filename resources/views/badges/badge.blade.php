@extends('layouts.app')

@section('pageTitle', $badge->title . ' ·')
@section('title', 'Badge | ' . $badge->title . ' ·')
@section('description', $title->title)
@section('image', '')
@section('url', url()->current())

@section('content')
    <div class="container-md">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                @include('badges.nav')
                @livewire('badges.badges', [
                'page' => 1,
                'perPage' => 10
                ])
            </div>
            <div class="col-sm">
                <div class="card mb-4">
                    <div class="card-body">
                        WIP
                    </div>
                </div>
                <x-footer />
            </div>
        </div>
    </div>
@endsection
