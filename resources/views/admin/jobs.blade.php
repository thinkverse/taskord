@extends('layouts.app')

@section('pageTitle', 'Admin - Jobs ·')
@section('title', 'Admin - Jobs ·')
@section('description', 'Get things done socially with Taskord.')
@section('image', '')
@section('url', url()->current())

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="container-md">
            @include('admin.nav')
            <div class="card">
                <iframe src="horizon" style="height:75vh">
            </div>
        </div>
    </div>
</div>
@endsection
