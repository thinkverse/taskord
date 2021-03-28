@extends('layouts.app')

@section('pageTitle', 'Milestones ·')
@section('title', 'Milestones ·')
@section('description', 'Browse milestones.')
@section('image', '')
@section('url', url()->current())

@section('content')
    <div class="container-md">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="pb-2 h5">
                    <x-heroicon-o-truck class="heroicon-2x ms-1 text-secondary" />
                    Milestones
                    <x-beta background="light" />
                </div>
                @livewire('milestone.milestones', [
                    'type' => $type,
                    'page' => 1,
                    'perPage' => 10
                ])
            </div>
            <div class="col-sm">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="h5 mb-3">
                            Share your achievements
                        </div>
                        @auth
                        <button type="button" class="btn btn-success text-white" data-bs-toggle="modal" data-bs-target="#newProductModal">
                            <x-heroicon-o-truck class="heroicon" />
                            Create a milestone
                        </button>
                        @livewire('milestone.create-milestone')
                        @endauth
                    </div>
                </div>
                <x-footer />
            </div>
        </div>
    </div>
@endsection
