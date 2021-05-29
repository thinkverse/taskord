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
                <div class="card-header h6 py-3">
                    <div class="h5">System Info</div>
                    Taskord's system info
                </div>
                <div class="card-body">
                    <h5 class="mb-3">System</h4>
                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <div class="card">
                                <div class="card-header fw-bold d-flex align-items-center">
                                    <x-heroicon-o-database class="heroicon me-1" />
                                    <span>Disk usage</span>
                                </div>
                                <div class="card-body">
                                    <div class="h5 mb-0">
                                        {{ formatBytes(disk_total_space('/') - disk_free_space('/')) }} / {{ formatBytes(disk_total_space('/')) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="card">
                                <div class="card-header fw-bold d-flex align-items-center">
                                    <x-heroicon-o-clock class="heroicon me-1" />
                                    <span>Uptime</span>
                                </div>
                                <div class="card-body">
                                    <div class="h5 mb-0">
                                        {{ $uptime }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
