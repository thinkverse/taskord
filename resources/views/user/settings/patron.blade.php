@extends('layouts.app')

@section('pageTitle', 'Settings / Patron ·')

@section('content')
    <div class="container-md">
        <div class="row justify-content-center mt-4">
            @include('user.settings.sidebar')
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header py-3">
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
                                <table class="table table-bordered border-secondary">
                                    <tbody>
                                        <tr class="fw-bold">
                                            <td colspan="2">
                                                <h4 class="text-secondary">Checkout ID</h4>
                                                <div class="text-success font-monospace">123</div>
                                            </td>
                                        </tr>
                                        <tr class="fw-bold">
                                            <td>
                                                <h4 class="text-secondary">Subscribed to</h4>
                                                <div>Tier 1 - $5/month</div>
                                            </td>
                                            <td>
                                                <h4 class="text-secondary">Subscribed at</h4>
                                                <div>123</div>
                                            </td>
                                        </tr>
                                        <tr class="fw-bold">
                                            <td>
                                                <h4 class="text-secondary">Last transaction</h4>
                                                <div>Tier 1 - $5/month</div>
                                            </td>
                                            <td>
                                                <h4 class="text-secondary">Next bill date</h4>
                                                <div>123</div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div>
                                    <div>
                                        <span class="fw-bold">Checkout ID:</span>
                                        <span class="text-danger fw-bold font-monospace">123</span>
                                    </div>
                                    <div>
                                        <span class="fw-bold">Subscribed to:</span>
                                        <span>Tier 1 - $5/month</span>
                                    </div>
                                    <div>
                                        <span class="fw-bold">Subscribed at:</span>
                                        <span>{{ carbon()->format('d M Y') }}</span>
                                    </div>
                                    <div>
                                        <span class="fw-bold">Last transaction:</span>
                                        <span>{{ carbon()->format('d M Y') }}</span>
                                    </div>
                                    <div>
                                        <span class="fw-bold">Next bill date:</span>
                                        <span>{{ carbon()->format('d M Y') }}</span>
                                    </div>
                                    <div class="mt-3">
                                        @if (true)
                                            <a class="btn btn-outline-success rounded-pill" href="" target="_blank"
                                                rel="noreferrer">
                                                <x-heroicon-o-pencil class="heroicon" />
                                                Update Payment
                                            </a>
                                        @endif
                                        @if (true)
                                            <a class="btn btn-outline-danger rounded-pill" href="" target="_blank"
                                                rel="noreferrer">
                                                <x-heroicon-o-x class="heroicon" />
                                                Cancel Patron
                                            </a>
                                        @endif
                                    </div>
                                </div>
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
