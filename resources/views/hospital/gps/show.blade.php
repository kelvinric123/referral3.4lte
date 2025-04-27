@extends('adminlte::page')

@section('title', 'GP Doctor Details')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>GP Doctor Details</h1>
        <a href="{{ route('hospital.gps.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-1"></i> Back to GPs
        </a>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $gp->name }}</h3>
            <div class="card-tools">
                @if($gp->is_active)
                    <span class="badge badge-success">Active</span>
                @else
                    <span class="badge badge-danger">Inactive</span>
                @endif
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="fas fa-envelope"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Email</span>
                            <span class="info-box-number">{{ $gp->email }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="fas fa-phone"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Phone</span>
                            <span class="info-box-number">{{ $gp->phone ?? 'Not specified' }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning"><i class="fas fa-venus-mars"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Gender</span>
                            <span class="info-box-number">{{ ucfirst($gp->gender ?? 'Not specified') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-primary"><i class="fas fa-graduation-cap"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Qualifications</span>
                            <span class="info-box-number">{{ $gp->qualifications ?? 'Not specified' }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="fas fa-business-time"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Years Experience</span>
                            <span class="info-box-number">{{ $gp->years_experience ?? '0' }} years</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger"><i class="fas fa-language"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Languages</span>
                            <span class="info-box-number">
                                @if(is_array($gp->languages) && count($gp->languages) > 0)
                                    {{ implode(', ', $gp->languages) }}
                                @else
                                    Not specified
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="fas fa-clinic-medical"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Clinic</span>
                            <span class="info-box-number">
                                @if($gp->clinic)
                                    <a href="{{ route('hospital.clinics.show', $gp->clinic) }}">
                                        {{ $gp->clinic->name }}
                                    </a>
                                @else
                                    Not assigned
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
                                <i class="fas fa-exchange-alt mr-1"></i> Referrals by this GP
                            </h3>
                        </div>
                        <div class="card-body">
                            @if($gp->referrals && $gp->referrals->isEmpty())
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle mr-1"></i> No referrals have been made by this GP yet.
                                </div>
                            @elseif($gp->referrals)
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Date</th>
                                                <th>Patient</th>
                                                <th>Consultant</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($gp->referrals as $referral)
                                                <tr>
                                                    <td>{{ $referral->id }}</td>
                                                    <td>{{ $referral->created_at->format('M d, Y') }}</td>
                                                    <td>{{ $referral->patient_name }}</td>
                                                    <td>
                                                        @if($referral->consultant)
                                                            {{ $referral->consultant->name }}
                                                        @else
                                                            Not assigned
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($referral->status == 'pending')
                                                            <span class="badge badge-warning">Pending</span>
                                                        @elseif($referral->status == 'approved')
                                                            <span class="badge badge-success">Approved</span>
                                                        @elseif($referral->status == 'rejected')
                                                            <span class="badge badge-danger">Rejected</span>
                                                        @elseif($referral->status == 'completed')
                                                            <span class="badge badge-info">Completed</span>
                                                        @else
                                                            <span class="badge badge-secondary">{{ ucfirst($referral->status) }}</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('hospital.referrals.show', $referral) }}" class="btn btn-sm btn-info">
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