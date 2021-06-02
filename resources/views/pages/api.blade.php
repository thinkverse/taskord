@extends('layouts.app')

@section('pageTitle', 'API ·')
@section('title', 'API ·')
@section('description', 'Get things done socially with Taskord.')
@section('image', '')
@section('url', url()->current())

@section('content')
<div class="container-md">
    <div class="card">
        <div class="card-header py-3">
            <span class="h5">API</span>
            <div>Taskord's Application Program Interface</div>
        </div>
        <div class="card-body">
            <div>
                Taskord built the Taskord app as an Open Source app. This SERVICE is provided by Taskord at no cost and is intended for use as is.
            </div>
        </div>
    </div>
</div>
@endsection
