@extends('layouts.app')

@section('pageTitle', 'Badges ·')
@section('title', 'Badges ·')
@section('description', 'Get things done socially with Taskord.')
@section('image', '')
@section('url', url()->current())

@section('content')
    <div class="container-md">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h5 class="mb-3 d-flex align-items-center">
                    <span class="me-2">Explore Badges</span>
                    <x:labels.beta />
                </h5>
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
                <div class="card mb-4">
                    <div class="card-body">
                        @can('staff.ops')
                            <a type="button" class="btn btn-outline-success rounded-pill" href="{{ route('badges.new') }}">
                                <x-heroicon-o-plus class="heroicon" />
                                Add new badge
                            </a>
                        @endcan
                    </div>
                </div>
                <x-footer />
            </div>
        </div>
    </div>
@endsection
