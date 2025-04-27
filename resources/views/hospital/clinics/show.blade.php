@extends('adminlte::page')

@section('title', 'Clinic Details')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Clinic Details</h1>
        <a href="{{ route('hospital.clinics.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-1"></i> Back to Clinics
        </a>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $clinic->name }}</h3>
            <div class="card-tools">
                @if($clinic->is_active)
                    <span class="badge badge-success">Active</span>
                @else
                    <span class="badge badge-danger">Inactive</span>
                @endif
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="fas fa-map-marker-alt"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Address</span>
                            <span class="info-box-number">{{ $clinic->address }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="fas fa-city"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">City/State</span>
                            <span class="info-box-number">{{ $clinic->city }}, {{ $clinic->state }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning"><i class="fas fa-phone"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Phone</span>
                            <span class="info-box-number">{{ $clinic->phone ?? 'Not specified' }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger"><i class="fas fa-envelope"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Email</span>
                            <span class="info-box-number">{{ $clinic->email ?? 'Not specified' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-primary"><i class="fas fa-clock"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Operating Hours</span>
                            <span class="info-box-number">{{ $clinic->operating_hours ?? 'Not specified' }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="fas fa-globe"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Website</span>
                            <span class="info-box-number">
                                @if($clinic->website)
                                    <a href="{{ $clinic->website }}" target="_blank">{{ $clinic->website }}</a>
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
                            <h3 class="card-title">
                                <i class="fas fa-user-md mr-1"></i> GPs in this Clinic
                            </h3>
                        </div>
                        <div class="card-body">
                            @if($clinic->gps->isEmpty())
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle mr-1"></i> No GPs are currently associated with this clinic.
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Qualification</th>
                                                <th>Experience</th>
                                                <th>Contact</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($clinic->gps as $gp)
                                                <tr>
                                                    <td>{{ $gp->name }}</td>
                                                    <td>{{ $gp->qualifications ?? 'N/A' }}</td>
                                                    <td>{{ $gp->years_experience ?? '0' }} years</td>
                                                    <td>
                                                        @if($gp->email)
                                                            <i class="fas fa-envelope mr-1"></i> {{ $gp->email }}<br>
                                                        @endif
                                                        @if($gp->phone)
                                                            <i class="fas fa-phone mr-1"></i> {{ $gp->phone }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($gp->is_active)
                                                            <span class="badge badge-success">Active</span>
                                                        @else
                                                            <span class="badge badge-danger">Inactive</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('hospital.gps.show', $gp) }}" class="btn btn-sm btn-info">
                                                            <i class="fas fa-eye"></i> View
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
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
        $(document).ready(function() {
            $('.table').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
@stop 