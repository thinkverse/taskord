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
                The WIP API lets you build third-party apps for WIP and integrate with existing ones.
            </div>
            <div class="mt-3">
                The API uses GraphQL. It's a relatively new technology that lets you request all the data you need in just one request. If you're unfamiliar with GraphQL we suggest you <a href="https://graphql.org/learn">read up on it first</a>.
            </div>
        </div>
    </div>
</div>
@endsection
