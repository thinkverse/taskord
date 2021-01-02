@extends('layouts.app')

@section('pageTitle', $product->name.' / Pending ·')
@section('title', $product->name.' / Pending ·')
@section('description', $product->description)
@section('image', $product->avatar)
@section('url', url()->current())

@section('content')
<div class="container-md">
    @include('product.profile')
    <div class="row justify-content-center mt-4">
        <div class="col-lg-8">
            @auth
            @if (
                auth()->user()->id === $product->owner->id or
                $product->members->contains(auth()->user()->id) &&
                !$product->owner->isFlagged
            )
                @livewire('create-task', ['product' => $product])
            @endif
            @endauth
            @livewire('product.tasks', [
                'type' => 'product.pending',
                'product' => $product,
                'page' => 1,
            ])
        </div>
        @include('product.sidebar')
    </div>
</div>
@endsection
