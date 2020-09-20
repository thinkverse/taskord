@extends('layouts.app')

@php
if ($user->lastname and $user->lastname) {
    $name = '('.$user->firstname.' '.$user->lastname.')';
} else if ($user->firstname) {
    $name = '('.$user->firstname.')';
} else {
    $name = '';
}
@endphp

@section('pageTitle', $user->username.' '.$name.' / Following ·')
@section('title', $user->username.' '.$name.' / Following ·')
@section('title', $user->username.' ('.$name.') ·')
@section('description', $user->bio)
@section('image', $user->avatar)
@section('url', url()->current())

@section('content')
<div class="container">
    @include('user.profile')
    <div class="row justify-content-center mt-4">
        <div class="col-md-8">
            @livewire('user.following', ['user' => $user])
        </div>
        @include('user.sidebar')
    </div>
</div>
@endsection
