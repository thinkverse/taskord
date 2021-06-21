@extends('layouts.app')

@section('pageTitle', 'Stafftool - System ·')
@section('title', 'Stafftool - System ·')
@section('description', 'Get things done socially with Taskord.')
@section('image', '')
@section('url', url()->current())

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="container-md">
            @include('staff.nav')
            <div class="card">
                <iframe src="https://p.datadoghq.eu/sb/b0c5b97c-d25c-11eb-85ec-da7ad0900005-4e34db2b858119245ce51dec85fb9bde?theme=light&from_ts=1624258169264&to_ts=1624261769264&live=true" style="height:73vh">
            </div>
        </div>
    </div>
</div>
@endsection
