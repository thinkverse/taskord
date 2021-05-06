@extends('layouts.app')

@section('pageTitle', 'Admin - Features ·')
@section('title', 'Admin - Features ·')
@section('description', 'Get things done socially with Taskord.')
@section('image', '')
@section('url', url()->current())

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="container-md">
            @include('admin.nav')
            <livewire:admin.features.features />
        </div>
    </div>
</div>
@endsection
