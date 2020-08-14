@extends('layouts.app')

@section('content')
<div class="container">
    <div class="mb-4 text-center">
        <img src="/images/patron.svg" width="100" />
    </div>
    <div class="card">
        <div class="card-header pt-3 pb-3">
            <span class="h5">Become a Patron</span>
            <div>Support Taskord by becoming a Patron.</div>
        </div>
        <div class="card-body">
            <div class="row align-items-center font-monospace">
                <div class="col-md-8">
                    <div class="font-weight-bold mb-3">You get the following benefits</div>
                    <ul>
                        <li>❤️ Good karma for helping a bootstrapped startup</li>
                        <li>💰 Financially commit to staying productive</li>
                        <li>🔥 Enable Dark Mode on the website</li>
                        <li>💎 Show off your support with the Patron badge</li>
                        <li>🔒 Make your tasks private</li>
                        <li>👍 Fund on-going development of the platform</li>
                    </ul>
                </div>
                <div class="col-sm">
                    <a class="btn btn-block btn-primary" href="{{ route('patron.tier', ['id' => 1]) }}">
                        Support $5/month
                    </a>
                    <a class="btn btn-block btn-primary" href="{{ route('patron.tier', ['id' => 2]) }}">
                        Support $10/month
                    </a>
                    <a class="btn btn-block btn-primary" href="{{ route('patron.tier', ['id' => 3]) }}">
                        Support $20/month
                    </a>
                    <a class="btn btn-block btn-primary" href="{{ route('patron.tier', ['id' => 4]) }}">
                        Support $50/month
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
