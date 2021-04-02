@extends('layouts.app')

@if ($type === 'milestones.opened')
@section('pageTitle', 'Milestones / Opened ·')
@else
@section('pageTitle', 'Milestones / Closed ·')
@endif
@section('title', 'Milestones ·')
@section('description', 'Browse milestones.')
@section('image', '')
@section('url', url()->current())

@section('content')
    <div class="container-md">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                @include('milestone.nav')
                @livewire('milestone.milestones', [
                    'type' => $type,
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
