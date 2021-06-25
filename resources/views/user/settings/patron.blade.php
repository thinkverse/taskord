@extends('layouts.app')

@section('pageTitle', 'Settings / Patron ·')

@section('content')
    <div class="container-md">
        <div class="row justify-content-center mt-4">
            @include('user.settings.sidebar')
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header py-4">
                        <span class="h5">Patron</span>
                        <div>Thanks for showing us your support!</div>
                    </div>
                    <div class="card-body">
                        @if (!$user->is_patron)
                            <a class="btn btn-outline-success rounded-pill" href="{{ route('patron.home') }}">
                                Support now!
                            </a>
                        @else
                            @if (!$user->patron)
                                <table class="table mb-0">
                                    <tbody>
                                        <tr class="fw-bold">
                                            <td colspan="2" class="pb-3">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div>
                                                        <h4 class="text-secondary">Checkout ID</h4>
                                                        <div>
                                                            <x-heroicon-o-hashtag class="heroicon text-secondary" />
                                                            <span class="text-success font-monospace">123</span>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        @if (true)
                                                            <a class="btn btn-outline-success rounded-pill" href=""
                                                                target="_blank" rel="noreferrer">
                                                                <x-heroicon-o-pencil class="heroicon" />
                                                                Update Payment
                                                            </a>
                                                        @endif
                                                        @if (true)
                                                            <a class="btn btn-outline-danger rounded-pill" href=""
                                                                target="_blank" rel="noreferrer">
                                                                <x-heroicon-o-x class="heroicon" />
                                                                Cancel Patron
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="fw-bold">
                                            <td class="py-4 border-0">
                                                <h4 class="text-secondary">Subscribed to</h4>
                                                <div>
                                                    <x-heroicon-o-clock class="heroicon text-secondary" />
                                                    <span>13</span>
                                                </div>
                                            </td>
                                            <td class="py-4 border-0">
                                                <h4 class="text-secondary">Subscribed at</h4>
                                                <div>
                                                    <x-heroicon-o-clock class="heroicon text-secondary" />
                                                    <span>13</span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="fw-bold">
                                            <td class="py-4 border-0">
                                                <h4 class="text-secondary">Last transaction</h4>
                                                <div>
                                                    <x-heroicon-o-clock class="heroicon text-secondary" />
                                                    <span>13</span>
                                                </div>
                                            </td>
                                            <td class="py-4 border-0">
                                                <h4 class="text-secondary">Next bill date</h4>
                                                <div>
                                                    <x-heroicon-o-clock class="heroicon text-secondary" />
                                                    <span>13</span>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            @else
                                <div>You are using gifted account!</div>
                                <a class="btn btn-outline-success rounded-pill mt-2" href="{{ route('patron.home') }}">
                                    Support now!
                                </a>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
