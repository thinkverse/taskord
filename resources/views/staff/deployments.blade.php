@extends('layouts.app')

@section('pageTitle', 'Stafftool - Deployments ·')
@section('title', 'Stafftool - Deployments ·')
@section('description', 'Get things done socially with Taskord.')
@section('image', '')
@section('url', url()->current())

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="container-md">
            @include('staff.nav')
            
        </div>
    </div>
</div>
@endsection
