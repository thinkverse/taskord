@extends('layouts.app')

@section('pageTitle', 'Settings / Products ·')

@section('content')
<div class="container-md">
    <div class="row justify-content-center mt-4">
        @include('user.settings.sidebar')
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header pt-3 pb-3">
                    <span class="h5">Products</span>
                    <div>Update your associated products.</div>
                </div>
                <div class="card-body">
                    Find out more about your associated products.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
