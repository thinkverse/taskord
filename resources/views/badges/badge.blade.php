@extends('layouts.app')

@section('pageTitle', $badge->title . ' ·')
@section('title', 'Badge | ' . $badge->title . ' ·')
@section('description', $badge->title)
@section('image', '')
@section('url', url()->current())

@section('content')
    <div class="badge-bg" style="background: {{ $badge->color }}"></div>
    <div class="container-md badge-card">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                @livewire('badges.single-badge', [
                'badge' => $badge,
                ], key($badge->id))
                <div class="card">
                    <div class="card-body">
                        <div class="h5">
                            People with {{ $badge->title }} badge
                        </div>
                        @livewire('badges.subscribers', [
                        'badge' => $badge,
                        ], key($badge->id))
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
