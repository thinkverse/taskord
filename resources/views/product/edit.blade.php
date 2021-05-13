@extends('layouts.app')

@section('pageTitle', 'Edit Product ·')

@section('content')
<div class="container-md">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            @auth
                @if (!auth()->user()->isFlagged)
                <livewire:product.edit-product :product="$product" />
                @else
                <div class="text-center">
                    <div class="alert alert-danger" role="alert">
                        You can't edit this product, because your account has been flagged 😢
                    </div>
                    <a class="btn btn-primary" href="{{ route('home') }}">Go to home</a>
                </div>
                @endif
            @endauth
        </div>
    </div>
</div>
<x-bottom-footer />
@endsection
