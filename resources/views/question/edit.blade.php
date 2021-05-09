@extends('layouts.app')

@section('pageTitle', 'Edit Question ·')

@section('content')
<div class="container-md">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            @auth
                @if (!auth()->user()->isFlagged)
                <livewire:question.edit-question :question="$question" />
                @else
                <div class="text-center">
                    <div class="alert alert-danger" role="alert">
                        You can't edit this question, because your account has been flagged 😢
                    </div>
                    <a class="btn btn-primary" href="{{ route('home') }}">Go to home</a>
                </div>
                @endif
            @endauth
        </div>
    </div>
</div>
@endsection
