@extends('adminlte::page')

@section('title', 'Hospital Details')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Hospital Details</h1>
        <a href="{{ route('hospital.my-hospital.edit') }}" class="btn btn-primary">
            <i class="fas fa-edit mr-1"></i> Edit Hospital
        </a>
    </div>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $hospital->name }}</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="fas fa-envelope"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Email</span>
                            <span class="info-box-number">{{ $hospital->email }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="fas fa-phone"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Phone</span>
                            <span class="info-box-number">{{ $hospital->phone ?? 'Not specified' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning"><i class="fas fa-map-marker-alt"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Address</span>
                            <span class="info-box-number">{{ $hospital->address ?? 'Not specified' }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-secondary"><i class="fas fa-city"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">City</span>
                            <span class="info-box-number">{{ $hospital->city ?? 'Not specified' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-primary"><i class="fas fa-flag"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">State</span>
                            <span class="info-box-number">{{ $hospital->state ?? 'Not specified' }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="fas fa-globe"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Country</span>
                            <span class="info-box-number">{{ $hospital->country ?? 'Not specified' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger"><i class="fas fa-map-pin"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Postal Code</span>
                            <span class="info-box-number">{{ $hospital->postal_code ?? 'Not specified' }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="fas fa-globe-americas"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Website</span>
                            <span class="info-box-number">
                                @if($hospital->website)
                                    <a href="{{ $hospital->website }}" target="_blank">{{ $hospital->website }}</a>
                                @else
                                    Not specified
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Hospital Status</h3>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="mr-3">
                                    @if($hospital->is_active)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-danger">Inactive</span>
                                    @endif
                                </div>
                                <div>
                                    <p class="mb-0">
                                        @if($hospital->is_active)
                                            Your hospital is currently active and visible to all users.
                                        @else
                                            Your hospital is currently inactive. Please contact the administrator.
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        console.log('Hospital details page loaded.');
    </script>
@stop 