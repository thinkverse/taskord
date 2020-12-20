@extends('layouts.app')

@section('pageTitle', 'Questions / Newest ·')
@section('title', 'Questions / Newest ·')
@section('description', 'Browse questions and discuss, answer, give feedbacks, etc.')
@section('image', '')
@section('url', url()->current())

@section('content')
    <div class="container-md">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                @include('question.nav')
                @if (session()->has('question_deleted'))
                    <div class="alert alert-success alert-dismissible fade show mt-2">
                        <button type="button" class="btn-close small" data-bs-dismiss="alert"></button>
                        <x-heroicon-o-check class="heroicon" />
                        {{ session('question_deleted') }}
                    </div>
                @endif
                @livewire('question.questions', ['type' => $type, 'page' => 1, 'perPage' => 10])
            </div>
            <div class="col-sm">
                @include('question.sidebar')
                <x-footer />
            </div>
        </div>
    </div>
@endsection
